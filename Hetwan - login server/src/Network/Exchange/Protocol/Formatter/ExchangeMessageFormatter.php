<?php

/**
 * @Author: jean
 * @Date:   2017-09-09 23:17:22
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 16:51:47
 */

namespace Hetwan\Network\Exchange\Protocol\Formatter;


class ExchangeMessageFormatter
{
	public static function helloConnectMessage() 
	{
		return 'HC';
	}

	public static function authentificationValidatedMessage()
	{
		return 'Av';
	}

	public static function authentificationFailedMessage()
	{
		return 'Af';
	}

	public static function ticketMessage($ticketKey, $ipAddress, $accountId)
	{
		return 'T' . $ticketKey . '|' . $ipAddress . '|' . $accountId;
	}
}