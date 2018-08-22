<?php

/**
 * @Author: jean
 * @Date:   2017-09-07 13:03:54
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-23 15:06:28
 */

namespace Hetwan\Network\Game\Handler;

use Hetwan\Network\Handler\HandlerInterface;

use Hetwan\Network\Exchange\ExchangeClient;

use Hetwan\Network\Game\Protocol\Formatter\GameMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\ApproachMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\PlayerMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\FactionMessageFormatter;


class PlayerSelectionHandler extends AbstractGameHandler
{
	public function handle($data)
	{
		switch (substr($data, 1, 1))
		{
			case 'A':
				$this->createPlayer($data);

				break;
			case 'D':
				$this->deletePlayer($data);

				break;
			case 'f':
				$this->doQueue();

				break;
			case 'i':
				$this->assignKey($data);

				break;
			case 'L':
				$this->playersList();

				break;
			case 'P':
				$this->generatePlayerName();

				break;
			case 'S':
				$this->playerSelection($data);

				break;
			case 'V':
				$this->regionalVersion();

				break;
		}
	}

	private function createPlayer($data)
	{
		$packet = explode('|', substr($data, 2));

		if ($this->getAccount()->getPlayers()->count() >= $this->getAccount()->getMaxPlayers())
			$this->send(PlayerMessageFormatter::maxPlayersReachedMessage());
		elseif (!(strlen($packet[0]) >= 2 && strlen($packet[0]) <= 20) || !preg_match('/^[a-zA-Z-]/', $packet[0]))
			$this->send(PlayerMessageFormatter::invalidPlayerNameMessage());
		elseif ($this->getLoginEntityManager()->getRepository('\Hetwan\Entity\Login\Player')->countByNameCaseInsensitive($packet[0]) > 0)
			$this->send(PlayerMessageFormatter::playerNameAlreadyTakenMessage());
		else
		{
			$player = \Hetwan\Helper\Player\PlayerHelper::createPlayer(
				$packet[0],
				$packet[1], 
				$packet[2], 
				[$packet[3], $packet[4], $packet[5]],
				$this->getContainer()->get('configuration')->get('server.id')
			);

			$player->setAccount($this->getAccount())
				   ->save();

			$this->getAccount()->addPlayer(
				$player
			)->save();

			$this->send(PlayerMessageFormatter::playerCreatedMessage());
			$this->playersList();
		}
	}

	private function deletePlayer($data)
	{
		$packet = explode('|', substr($data, 2));

		if ((!$packet[1] || $packet[1] == $this->getAccount()->getSecretAnswer()) && null != ($player = \Hetwan\Helper\AccountHelper::hasPlayer($this->getAccount()->getPlayers(), $packet[0], true)))
		{
			$player->remove();

			$this->playersList();
		}
		else
			$this->send(PlayerMessageFormatter::playerDeletetionFailureMessage());
	}

	private function doQueue() // TODO: make queue system
	{
		$this->send(GameMessageFormatter::queueMessage(1, 0, 0, 1));
	}

	private function assignKey($data)
	{
		$this->getClient()->setKey(substr($data, 2));
	}

	private function generatePlayerName()
	{
		$this->send(PlayerMessageFormatter::generatedPlayerNameMessage(
			\Hetwan\Helper\Player\PlayerHelper::generatePlayerName()
		));
	}

	private function playersList()
	{
		$this->send(PlayerMessageFormatter::playersListMessage(
			$this->getAccount(), 
			$this->getContainer()->get('configuration')->get('server.id')
		));
	}

	private function playerSelection($data)
	{
		$playerId = substr($data, 2);
		$player = \Hetwan\Helper\AccountHelper::hasPlayer($this->getAccount()->getPlayers(), $playerId, $returnEntity = true);

		if (null !== $player)
		{
			$this->getClient()->setPlayer($player->refresh());

			$this->send(ApproachMessageFormatter::playerSelectionMessage($player));

			$this->getClient()->setHandler('\Hetwan\Network\Game\Handler\GameHandlerContainer');

			return HandlerInterface::COMPLETED;
		}
	}

	private function regionalVersion()
	{
		$this->send(ApproachMessageFormatter::regionalVersionResponseMessage($this->getAccount()->getCommunity()));
	}
}