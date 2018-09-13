<?php

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

	public static function accountTicketMessage(string $ticketKey, string $ipAddress, int $accountId) : string
	{
		return 'T' . $ticketKey . '|' . $ipAddress . '|' . $accountId;
	}

	public static function accountDisconnectMessage(int $accountId) : string
	{
		return 'Ad' . $accountId;
	}
}