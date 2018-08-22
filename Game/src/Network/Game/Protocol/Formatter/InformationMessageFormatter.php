<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-25 15:40:09
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-18 14:20:54
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


class InformationMessageFormatter
{
	public static function welcomeMessage()
	{
		return 'Im189';
	}

    public static function currentIpAddressInformationMessage($currentIpAddress)
    {
        return 'Im0153;' . $currentIpAddress;
    }

    public static function lastConnectionInformationMessage($lastConnectionDate, $lastIpAddress)
    {
        return 'Im0152;' . $lastConnectionDate->format('Y~m~d~h~i') . '~' . $lastIpAddress;
    }

    public static function sameMessageAsLastMessage()
    {
        return 'Im184';
    }

    public static function channelRestrictedMessage($waitTimeLeft)
    {
        return 'Im0115;' . $waitTimeLeft;
    }
}