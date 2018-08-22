<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-25 15:37:13
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-26 00:04:45
 */

namespace Hetwan\Network\Game\Protocol\Enum;


class ChannelEnum extends AbstractEnum
{
	const FACTION = '!',
    	  TEAM = '#',
    	  PARTY = '$',
    	  GUILD = '%',
    	  GENERAL = '*',
    	  TRADE = ':',
    	  RECRUITMENT = '?',
    	  ADMIN = '@',
    	  INFORMATION = 'i';
}