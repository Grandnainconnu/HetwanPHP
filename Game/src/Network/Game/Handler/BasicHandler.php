<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-26 23:18:59
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-27 01:25:43
 */

namespace Hetwan\Network\Game\Handler;

use Hetwan\Loader\MapDataLoader;

use Hetwan\Helper\MapDataHelper;
use Hetwan\Helper\Console\ConsoleHelper;
use Hetwan\Helper\Player\PlayerHelper;

use Hetwan\Network\Game\Protocol\Enum\ChannelEnum;

use Hetwan\Network\Game\Protocol\Formatter\InformationMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\BasicMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\ChannelMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\GameMessageFormatter;


trait MessageTrait
{
	private function channelMessageVerification($channel, $message)
	{
		static $lastMessage = [
			ChannelEnum::TRADE => ['interval' => 120, 'content' => null, 'date' => null],
			ChannelEnum::RECRUITMENT => ['interval' => 120, 'content' => null, 'date' => null],
			ChannelEnum::GENERAL => []
		];

		$currDate = new \DateTime('NOW');

		if (array_key_exists('date', $lastMessage[$channel]) &&
			$lastMessage[$channel]['date'] != null &&
			($interval = $currDate->getTimestamp() - $lastMessage[$channel]['date']->getTimestamp()) < $lastMessage[$channel]['interval'])
			$this->send(InformationMessageFormatter::channelRestrictedMessage((int) $lastMessage[$channel]['interval'] - $interval));
		elseif (array_key_exists('content', $lastMessage[$channel]) &&
				$lastMessage[$channel]['content'] == $message)
			$this->send(InformationMessageFormatter::sameMessageAsLastMessage());
		else
		{
			if (array_key_exists('date', $lastMessage[$channel]))
				$lastMessage[$channel]['date'] = $currDate;

			if (array_key_exists('content', $lastMessage[$channel]))
				$lastMessage[$channel]['content'] = $message;

			return (true);
		}

		return (false);
	}
}

class BasicHandler extends AbstractGameHandler
{
	use MessageTrait;

	private $consoleHelper;

	public function __construct($client)
	{
		parent::__construct($client);

		$this->consoleHelper = new ConsoleHelper();
	}

	public function handle($data)
	{
		switch (substr($data, 0, 1))
		{
			case 'a':
				$this->mapAdminTeleport($data);

				break;
			case 'A':
				$consoleResponse = $this->consoleHelper->handle(explode(' ', substr($data, 1)), $this->getPlayer()->getId());

				$this->send(BasicMessageFormatter::consoleMessage($consoleResponse[0], $consoleResponse[1]));

				break;
			case 'D':
				$this->currentServerDate();

				break;
			case 'M':
				$this->sendMessage(substr($data, 1));
				break;
			default:
				echo "Unable to handle basic action packet: {$data}\n";

				break;
		}
	}

	private function mapAdminTeleport(string $data)
	{
		$mapPosition = explode(',', substr($data, 2));

		if (($mapData = MapDataLoader::getMapWithPosition((int) $mapPosition[0], (int) $mapPosition[1])) == null)
			return;

		PlayerHelper::teleport($this->getClient(), $mapData, $this->getPlayer()->getCellId());
	}

	private function currentServerDate()
	{
		$this->send(BasicMessageFormatter::currentDateMessage());
	}

	private function sendMessage($data)
	{
		$args = explode('|', $data);

		if (strlen($args[0]) > 1)
			if (($receiver = \Hetwan\Network\Game\GameServer::getClientWithPlayerName($args[0])) != null && PlayerHelper::playerCanReceiveFromPlayer($this->getPlayer(), $receiver->getPlayer()))
			{
				$this->send(ChannelMessageFormatter::clientPrivateMessage(false, $receiver->getPlayer()->getId(), $receiver->getPlayer()->getName(), $args[1]));
				$receiver->send(ChannelMessageFormatter::clientPrivateMessage(true, $this->getPlayer()->getId(), $this->getPlayer()->getName(), $args[1]));
			}
			elseif ($receiver == null)
				$this->send(BasicMessageFormatter::receiverCannotReceiveMessage($args[0]));
			else
				$this->send(BasicMessageFormatter::noOperationMessage());
		else
		{
			$condition = false;

			switch ($args[0])
			{
				case ChannelEnum::TRADE:
				case ChannelEnum::RECRUITMENT:
					$condition = function ($target) {
						return (MapDataHelper::getAreaIdWithMapId($this->getPlayer()->getMapId()) == MapDataHelper::getAreaIdWithMapId($target->getMapId()));
					};

					break;
				case ChannelEnum::GENERAL:
					$condition = function ($target) {
						return ($this->getPlayer()->getMapId() == $target->getMapId());
					};

					break;
			}

			if (!$this->channelMessageVerification($args[0], $args[1]) || $condition == false)
				return ;

			foreach (\Hetwan\Network\Game\GameServer::getClientsPool() as $client)
				if (($target = $client->getPlayer()) != null && $condition($target))
					$client->send(ChannelMessageFormatter::clientChannelMessage($args[0], $this->getPlayer()->getId(), $this->getPlayer()->getName(), $args[1]));
		}
	}
}