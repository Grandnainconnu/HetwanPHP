<?php

/**
 * @Author: jean
 * @Date:   2017-09-16 00:35:30
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 21:24:19
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


class GameMessageFormatter
{
	public static function helloConnectMessage()
	{
		return 'HG';
	}

	public static function queueMessage($position, $subscribers, $nonSubscribers, $isSubscriber, $queuId = 1)
	{
		return 'Af' . $position . '|' . $subscribers . '|' . $nonSubscribers . '|' . $isSubscriber . '|' . $queuId;
	}
}