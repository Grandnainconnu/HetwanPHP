<?php

namespace Hetwan\Helper;


final class NetworkHelper
{
	public static function getCleanIpAddress(string $ipAddress) : string
	{
		preg_match('/(.*?):\/\/(?P<ipAddress>.*?):/', $ipAddress, $matches);

		return $matches['ipAddress'];
	}
}