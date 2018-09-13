<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-24 15:36:53
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 19:00:12
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


class FactionMessageFormatter
{
	public static function subAreasFactionsMessage($subAreas)
	{
		$packet = ['al'];

		foreach ($subAreas as $subArea) {
			$packet[] = $subArea->getId() . ';' . $subArea->getFactionId();
		}

		return implode('|', $packet);
	}
}