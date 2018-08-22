<?php

/**
 * @Author: jeanw
 * @Date:   2017-11-04 17:33:02
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-11-04 17:42:05
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


class EnvironementMessageFormatter
{
	public static function updateActorOrientationMessage($actorId, $orientation)
	{
		return 'eD' . $actorId . '|' . $orientation;
	}
}