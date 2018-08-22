<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-28 21:15:33
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-28 21:40:50
 */

namespace Hetwan\Helper\Characteristic;


class CharacteristicHelper
{
	public static function makePlayerCharacteristics($player)
	{
		return new PlayerCharacteristics($player);
	}

	public static function upgradePlayerCharacteristic($player, $characteristicId)
	{
		$characteristic = $player->getCharacteristics()->getCharacteristic($characteristicId);

		foreach (\Hetwan\Helper\Player\Breed\BreedHelper::getBreedFromId($player->getBreed())['characteristics'][$characteristicId] as $level)
			if (intval($level['range'][0]) <= $characteristic->getBase() && ($level['range'][1] == null || intval($level['range'][1]) >= $characteristic->getBase()) && ($pointsOfCharacteristics = $player->getPointsOfCharacteristics() - intval($level['cost'])) >= 0)
			{
				// Remove points of characteristic
				$player->setPointsOfCharacteristics($pointsOfCharacteristics);
				
				// Update charac base
				$characteristic->setBase($characteristic->getBase() + intval($level['bonus']));

				// Update secondary characs (initiative, prospection, pods)
				$player->getCharacteristics()->updateSecondaryCharacteristics($player);

				return (true);
			}
	}
}