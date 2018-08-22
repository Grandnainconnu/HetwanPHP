<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-18 17:08:20
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-28 21:24:06
 */

namespace Hetwan\Network\Game\Handler;

use Hetwan\Helper\Characteristic\CharacteristicHelper;

use Hetwan\Network\Game\Protocol\Enum\CharacteristicTypeEnum;

use Hetwan\Network\Game\Protocol\Formatter\GameMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\ItemMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\ApproachMessageFormatter;


class ApproachHandler extends AbstractGameHandler
{
	public function handle($data)
	{
		switch (substr($data, 0, 1))
		{
			case 'B':
				$this->boostPlayerCharacteristic(substr($data, 1));

				break;
			default:
				echo "Unable to handle approach action packet: {$data}\n";

				break;
		}
	}

	private function boostPlayerCharacteristic($data)
	{
		if (CharacteristicHelper::upgradePlayerCharacteristic($this->getPlayer(), strtolower(CharacteristicTypeEnum::toString(intval($data) - 5))))
		{
			$this->send(GameMessageFormatter::playerStatisticsMessage($this->getPlayer()));
			
			$this->send(ItemMessageFormatter::inventoryStatsMessage(
				$this->getPlayer()->getCharacteristics()->getCharacteristic('pods')->getCurrent(),
				$this->getPlayer()->getCharacteristics()->getCharacteristic('pods')->getTotal()
			));
		}
		else
			$this->send(ApproachMessageFormatter::boostCharacteristicErrorMessage());
	}
}