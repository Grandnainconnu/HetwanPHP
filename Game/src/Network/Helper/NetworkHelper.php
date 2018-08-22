<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-25 17:06:02
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 17:15:12
 */

namespace Hetwan\Network\Helper;


class NetworkHelper
{
	public static function getCleanIpAddress($ipAddress)
	{
		preg_match('/(.*?):\/\/(?P<ipAddress>.*?):/', $ipAddress, $matches);

		return $matches['ipAddress'];
	}
}