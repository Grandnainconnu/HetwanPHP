<?php

namespace Hetwan\Network\Game\Handler;

use Hetwan\Network\Game\Base\Handler\HandlerTrait;
use Hetwan\Network\Game\Protocol\Formatter\ChannelMessageFormatter;


class ChannelHandler extends \Hetwan\Network\Base\Handler\Handler
{
	use HandlerTrait;

	public function handle(string $data) : bool
	{
		switch ($data[0]) {
			case 'C':
				$channel = substr($data, 2, 1);

				if (substr($data, 1, 1) == '+') {
                    $this->parseAddChannelMessage($channel);
                } else {
                    $this->parseRemoveChannelMessage($channel);
                }

				break;
			default:
                $this->logger->debug('Unable to handle channel packet: ' . $data . PHP_EOL);

				break;
		}

		return true;
	}

	private function parseAddChannelMessage(string $channel) : void
	{
		if (in_array($channel, ($channels = explode(';',$this->getPlayer()->getChannels()))) === false) {
            $this->getPlayer()->setChannels(implode(';', array_merge($channels, [$channel])));
        }

		$this->send(ChannelMessageFormatter::addChannelsMessage([$channel]));
	}

	private function parseRemoveChannelMessage(string $channel) : void
	{
		if (in_array($channel, ($channels = explode(';',$this->getPlayer()->getChannels())))) {
			unset($channels[array_search($channel, $channels)]);

			$this->getPlayer()->setChannels(implode(';', $channels));
		}

		$this->send(ChannelMessageFormatter::removeChannelsMessage([$channel]));
	}
}