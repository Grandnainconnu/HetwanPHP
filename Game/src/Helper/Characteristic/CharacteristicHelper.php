<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-28 21:15:33
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-28 21:40:50
 */

namespace Hetwan\Helper\Characteristic;

use Hetwan\Helper\Characteristic\Player\Characteristics;
use Hetwan\Helper\Player\Breed\BreedHelper;


final class CharacteristicHelper
{
	public static function generatePlayerCharacteristics(\Hetwan\Entity\Game\PlayerEntity $player) : \Hetwan\Helper\Characteristic\Player\Characteristics
	{
		return new Characteristics($player);
	}

	public static function upgradePlayerCharacteristic(string $characteristicId, \Hetwan\Entity\Login\PlayerEntity $player) : bool
	{
		$characteristic = $player->getCharacteristics()->getCharacteristic($characteristicId);
		$levels = BreedHelper::getFromId($player->getBreed())['characteristics'][$characteristicId];
		$updated = false;

		foreach ($levels as $level) {
			if ((int)$level['range'][0] <= $characteristic->getBase() and 
				($level['range'][1] === null or (int)$level['range'][1] >= $characteristic->getBase()) and
				($pointsOfCharacteristics = $player->getPointsOfCharacteristics() - (int)($level['cost'])) >= 0
            ) {
				// Remove points of characteristic
				$player->setPointsOfCharacteristics($pointsOfCharacteristics);

				// Update base
				$characteristic->setBase($characteristic->getBase() + (int)$level['bonus']);

				$updated = true;

				break;
			}
		}

		unset($levels);

		return $updated;
	}
}