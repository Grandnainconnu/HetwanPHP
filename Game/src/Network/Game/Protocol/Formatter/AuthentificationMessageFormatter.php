<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-23 17:14:44
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-23 17:15:27
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


class AuthentificationMessageFormatter
{
    public static function badTicketMessage()
    {
    	return 'M130';
    }

    public static function authenticationFailedMessage()
    {
    	return 'M031';
    }

    public static function authenticationSucceedMessage($key)
    {
        return 'ATK' . $key;
    }
}