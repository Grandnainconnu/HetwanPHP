<?php

/**
 * @Author: jeanw
 * @Date:   2017-11-04 17:29:52
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-11-04 17:41:21
 */

namespace Hetwan\Network\Game\Handler;

use Hetwan\Helper\MapDataHelper;


class EnvironementHandler extends AbstractGameHandler
{
	public function handle($data)
	{
		switch (substr($data, 0, 1))
		{
			case 'D':
				$this->changePlayerOrientation(substr($data, 1));

				break;
			default:
				echo "Unable to handle environement packet: {$data}\n";

				break;
		}
	}

	private function changePlayerOrientation($direction)
	{
		$this->getPlayer()->setOrientation($direction);

		MapDataHelper::updatePlayerOrientationInMap((int) $this->getPlayer()->getMapId(), $this->getPlayer());
	}
}