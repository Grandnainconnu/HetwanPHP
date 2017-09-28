<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 21:29:02
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-18 14:46:46
 */

namespace Hetwan\Helper;

class AccountHelper
{
	public static function hasPlayer($players, $playerId, $returnEntity = false)
	{
		foreach ($players as $player)
			if ($player->getId() == $playerId)
				return !$returnEntity ? true : $player;

		return null;
	}
}