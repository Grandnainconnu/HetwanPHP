<?php

/**
 * @Author: jean
 * @Date:   2017-09-09 23:17:22
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 12:30:14
 */

namespace Hetwan\Network\Exchange\Protocol\Formatter;


final class ExchangeMessageFormatter
{
	public static function helloConnectMessage() : string
	{
		return 'HC';
	}

	public static function authentificationValidatedMessage() : string
	{
		return 'Av';
	}

	public static function authentificationFailedMessage() : string
	{
		return 'Af';
	}

	public static function accountTicketMessage($ticketKey, $ipAddress, $accountId) : string
	{
		return 'T' . $ticketKey . '|' . $ipAddress . '|' . $accountId;
	}

	public static function accountDisconnectMessage($accountId) : string
	{
		return 'Ad' . $accountId;
	}
}