<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-16 13:17:21
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-16 14:48:24
 */

namespace Hetwan\Network\Game\Handler;

use Hetwan\Network\Game\Protocol\Formatter\ChannelMessageFormatter;

use Hetwan\Network\Game\Protocol\Enum\ChannelEnum;

class ChannelHandler extends AbstractGameHandler
{
	public function handle($data)
	{
		switch (substr($data, 0, 1))
		{
			case 'C':
				$channel = substr($data, 2, 1);

				if (substr($data, 1, 1) == '+')
					$this->parseAddChannelMessage($channel);
				else
					$this->parseRemoveChannelMessage($channel);
				break;
			default:
				echo "Unable to handle channel packet: {$data}\n";

				break;
		}
	}

	private function parseAddChannelMessage($channel)
	{
		if (in_array($channel, ($channels = $this->getPlayer()->getChannels())) == false)
			$this->getPlayer()->setChannels(array_merge($channels, [$channel]));

		$this->send(ChannelMessageFormatter::addChannelsMessage([$channel]));
	}

	private function parseRemoveChannelMessage($channel)
	{
		if (in_array($channel, ($channels = $this->getPlayer()->getChannels())))
		{
			unset($channels[array_search($channel, $channels)]);

			$this->getPlayer()->setChannels($channels);
		}

		$this->send(ChannelMessageFormatter::removeChannelsMessage([$channel]));
	}
}