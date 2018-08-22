<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-26 21:55:00
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-23 22:17:00
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


class BasicMessageFormatter
{
	public static function currentDateMessage()
	{
		$currentDate = new \DateTime('NOW');

		return 'BD' . $currentDate->format('Y|m|d');
	}

	public static function noOperationMessage()
	{
		return 'BN';
	}

	public static function receiverCannotReceiveMessage($receiverName)
	{
		return 'cMEf' . $receiverName;
	}

	public static function consoleMessage($message, $type)
	{
		return 'BAT' . $type . $message;
	}
}