<?php

/**
 * @Author: jean
 * @Date:   2017-09-16 22:59:05
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-16 23:05:37
 */

namespace Dofus;

final class NameGenerator
{
    private static $beginning = [
    	'Kr', 'Ca', 'Ra', 'Mrok', 'Cru',
        'Ray', 'Bre', 'Zed', 'Drak', 'Mor', 'Jag', 'Mer', 'Jar', 'Mjol',
        'Zork', 'Mad', 'Cry', 'Zur', 'Creo', 'Azak', 'Azur', 'Rei', 'Cro',
        'Mar', 'Luk'
    ];

    private static $middle = [
    	'air', 'ir', 'mi', 'sor', 'mee', 'clo',
        'red', 'cra', 'ark', 'arc', 'miri', 'lori', 'cres', 'mur', 'zer',
        'marac', 'zoir', 'slamar', 'salmar', 'urak'
    ];
    
    private static $ending = [
    	'd', 'ed', 'ark', 'arc', 'es', 'er', 'der',
        'tron', 'med', 'ure', 'zur', 'cred', 'mur'
    ];

    static function generate()
   	{
		return self::$beginning[rand(0, count(self::$beginning)] + self::$middle[rand(0, count(self::$middle)] + self::$endig[rand(0, count(self::$ending)];
    }
}