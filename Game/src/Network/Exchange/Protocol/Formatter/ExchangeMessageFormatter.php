<?php

/**
 * @Author: jean
 * @Date:   2017-09-09 23:17:22
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 12:29:18
 */

namespace Hetwan\Network\Exchange\Protocol\Formatter;


class ExchangeMessageFormatter
{
	public static function helloConnectMessage($serverId, $serverKey, $ipAddress, $port) 
	{
		return 'HC' . $serverId . '|' . $serverKey . '|' . $ipAddress . ':' . $port;
	}

	public static function serverStateMessage($state)
	{
		return 'Su' . $state;
	}
}