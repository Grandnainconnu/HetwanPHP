<?php

/**
 * @Author: jean
 * @Date:   2017-09-09 23:17:22
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 22:07:09
 */

namespace Hetwan\Network\Exchange\Protocol\Formatter;


class ExchangeMessageFormatter
{
	public static function helloConnectMessage($serverId, $serverKey, $ipAddress, $port) 
	{
		return 'HC' . $serverId . '|' . $serverKey . '|' . $ipAddress . ':' . $port;
	}

	public static function authentificationValidatedMessage()
	{
		return 'Av';
	}

	public static function serverStateMessage($state)
	{
		return 'Su' . $state;
	}

	public static function serverAccountPlayers($accountId, $players)
	{
		return 'Sp' . $accountId . '|' . $players;
	}
}