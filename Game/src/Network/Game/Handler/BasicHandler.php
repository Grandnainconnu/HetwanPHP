<?php

namespace Hetwan\Network\Game\Handler;

use DateTime;

use Hetwan\Helper\Player\PlayerHelper;
use Hetwan\Network\Game\Base\Handler\HandlerTrait;
use Hetwan\Network\Game\Protocol\Enum\ChannelEnum;
use Hetwan\Network\Game\Protocol\Formatter\{
    InformationMessageFormatter,
    BasicMessageFormatter,
    ChannelMessageFormatter
};


trait MessageTrait
{
    /**
     * Check if the message fill all the conditions to be sent
     * @param string $channel
     * @param string $message
     * @return bool
     */
	private function channelMessageVerification(string $channel, string $message) : bool
	{
		static $lastMessage = [
			ChannelEnum::TRADE => [
			    'interval' => 120,
                'content' => null,
                'date' => null
            ],
			ChannelEnum::RECRUITMENT => [
			    'interval' => 120,
                'content' => null,
                'date' => null
            ],
			ChannelEnum::GENERAL => [],
            ChannelEnum::ADMIN => [],
		];

		$currDate = new DateTime('NOW');

		if (array_key_exists('date', $lastMessage[$channel]) and
			$lastMessage[$channel]['date'] !== null and
			($interval = $currDate->getTimestamp() - $lastMessage[$channel]['date']->getTimestamp()) < $lastMessage[$channel]['interval']
        ) {
            $this->send(InformationMessageFormatter::channelRestrictedMessage((int)$lastMessage[$channel]['interval'] - $interval));
        } elseif (array_key_exists('content', $lastMessage[$channel]) and
				$lastMessage[$channel]['content'] === $message
        ) {
            $this->send(InformationMessageFormatter::sameMessageAsLastMessage());
        } else {
			if (array_key_exists('date', $lastMessage[$channel])) {
                $lastMessage[$channel]['date'] = $currDate;
            }

			if (array_key_exists('content', $lastMessage[$channel])) {
                $lastMessage[$channel]['content'] = $message;
            }

			return true;
		}

		return false;
	}
}

class BasicHandler extends \Hetwan\Network\Base\Handler\Handler
{
	use MessageTrait,
        HandlerTrait;

    /**
     * @Inject
     * @var \Hetwan\Helper\Console\ConsoleHelper
     */
	private $consoleHelper;

    /**
     * @Inject
     * @var \Hetwan\Helper\MapDataHelper
     */
    private $mapDataHelper;

    /**
     * @Inject
     * @var \Hetwan\Helper\Player\PlayerHelper
     */
    private $playerHelper;

    /**
     * @Inject
     * @var \Hetwan\Loader\MapDataLoader
     */
    private $mapDataLoader;

    /**
     * @Inject
     * @var \Hetwan\Network\Game\GameServer
     */
    private $gameServer;

    /**
     * Handle basic packets
     * @param string $data
     * @return bool
     */
	public function handle(string $data) : bool
	{
		switch (substr($data, 0, 1)) {
			case 'a':
				$this->teleport($data);

				break;
			case 'A':
                $this->handleConsoleEntry($data);

				break;
			case 'D':
				$this->currentServerDate();

				break;
			case 'M':
				$this->sendMessage(substr($data, 1));
				break;
			default:
                $this->logger->debug('Unable to handle basic packet: ' . $data . PHP_EOL);

				break;
		}

		return true;
	}

    /**
     * Handle console entries
     * @param string $data
     */
	private function handleConsoleEntry(string $data) : void
    {
        $consoleResponse = $this->consoleHelper->handle(
            explode(' ', substr($data, 1)),
            $this->getPlayer()->getId()
        );

        $this->send(BasicMessageFormatter::consoleMessage($consoleResponse[0], $consoleResponse[1]));
    }

    /**
     * IG teleportation (only for admins)
     * @param string $data
     * @return void
     */
	private function teleport(string $data) : void
	{
		list($x, $y) = explode(',', substr($data, 2));

		if (($mapData = $this->mapDataLoader->getBy(['x' => $x, 'y' => $y], false, true)) === null) {
			return;
        }

        $this->mapDataHelper->teleportPlayer($mapData, $this->getPlayer()->getCellId(), $this->client);
	}


    /**
     * Send current server date
     * @return void
     */
	private function currentServerDate() : void
	{
		$this->send(BasicMessageFormatter::currentDateMessage());
	}

    /**
     * Handle player message in every channels
     * @param string $data
     * @return void
     */
	private function sendMessage(string $data) : void
	{
	    list($receiverOrChannel, $message) = explode('|', $data, 2);

		if (strlen($receiverOrChannel) > 3) {
            if (($receiverClient = $this->playerHelper->getClientWithName($receiverOrChannel)) !== null and
                PlayerHelper::canReceiveFrom($this->getPlayer(), $receiverClient->getPlayer())) {
                $this->send(ChannelMessageFormatter::clientPrivateMessage(false, $receiverClient->getPlayer()->getId(), $receiverClient->getPlayer()->getName(), $message));
                $receiverClient->send(ChannelMessageFormatter::clientPrivateMessage(true, $this->getPlayer()->getId(), $this->getPlayer()->getName(), $message));
            } elseif ($receiverClient === null) {
                $this->send(BasicMessageFormatter::receiverCannotReceiveMessage($receiverOrChannel));
            } else {
                $this->send(BasicMessageFormatter::noOperationMessage());
            }
        } else {
            $condition = false;

            switch ($receiverOrChannel) {
                case ChannelEnum::ADMIN:
                    $condition = function (\Hetwan\Entity\Game\PlayerEntity $target) {
                        return true;
                    };

                    break;
                case ChannelEnum::TRADE:
                case ChannelEnum::RECRUITMENT:
                    $condition = function (\Hetwan\Entity\Game\PlayerEntity $target) {
                        return $this->mapDataHelper->getAreaId($this->getPlayer()->getMapId()) === $this->mapDataHelper->getAreaId($target->getMapId());
                    };

                    break;
                case ChannelEnum::GENERAL:
                    $condition = function (\Hetwan\Entity\Game\PlayerEntity $target) {
                        return $this->getPlayer()->getMapId() === $target->getMapId();
                    };

                    break;
            }

            if (!$this->channelMessageVerification($receiverOrChannel, $message) or $condition === false) {
                return;
            }

            $clients = $this->gameServer->getClientsPool();

            foreach ($clients as $client) {
                if (($target = $client->getPlayer()) !== null and $condition($target)) {
                    $client->send(ChannelMessageFormatter::clientChannelMessage(
                        $receiverOrChannel,
                        $this->getPlayer()->getId(),
                        $this->getPlayer()->getName(),
                        $message
                    ));
                }
            }
        }
	}
}