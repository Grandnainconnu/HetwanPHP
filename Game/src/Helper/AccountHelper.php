<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 21:29:02
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-24 14:43:22
 */

namespace Hetwan\Helper;


class AccountHelper extends AbstractHelper
{
	public static function hasPlayer($players, $playerId, $returnEntity = false)
	{
		foreach ($players as $player)
			if ($player->getId() == $playerId)
				return !$returnEntity ? true : $player;

		return null;
	}
}