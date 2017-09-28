<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-03 21:35:27
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-20 16:35:24
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


class AccountMessageFormatter
{
    public static function authenticationSucceedMessage($key)
    {
        return 'ATK' . $key;
    }

    public static function invalidTicketMessage()
    {
    	return 'M130';
    }

    public static function authenticationFailedMessage()
    {
    	return 'M031';
    }

    public static function requestRegionalVersionMessage($regionalVersion)
    {
    	return 'AV' . $regionalVersion;
    }
}