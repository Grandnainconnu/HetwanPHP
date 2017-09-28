<?php

/**
 * @Author: jean
 * @Date:   2017-09-18 13:48:16
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-24 15:14:32
 */

namespace Hetwan\Helper;

use Hetwan\Network\Game\Protocol\Enum\ItemPositionEnum;


class PlayerHelper extends AbstractHelper
{
	public static function makeAccessories(\Hetwan\Entity\Login\Player $player)
	{
		$accessories = [
			ItemPositionEnum::CAP => null,
			ItemPositionEnum::MANTLE => null,
			ItemPositionEnum::ANIMAL => null,
			ItemPositionEnum::SHIELD => null
		];

		$playerAccessories = self::getGameEntityManager()
			->getRepository('\Hetwan\Entity\Game\Item')
			->findBy(['playerId' => $player->getId(), 'position' => [ItemPositionEnum::CAP, ItemPositionEnum::MANTLE, ItemPositionEnum::ANIMAL, ItemPositionEnum::SHIELD]]);

		foreach ($playerAccessories as $accessory)
			$accessories[$accessory->getPosition()] = dechex($accessory->getTemplateId());

		return ',' . implode(',', $accessories);
	}

	public static function getPlayerEquipedItems($playerId)
	{
		return self::getGameEntityManager()
			->getRepository('\Hetwan\Entity\Game\Item')
			->findBy([
				'playerId' => $playerId, 
				'position' => [
					ItemPositionEnum::AMULET,
					ItemPositionEnum::WEAPON,
					ItemPositionEnum::RING_ONE,
					ItemPositionEnum::WAISTBAND,
					ItemPositionEnum::RING_TWO,
					ItemPositionEnum::BOOTS,
					ItemPositionEnum::CAP,
					ItemPositionEnum::MANTLE,
					ItemPositionEnum::ANIMAL,
					ItemPositionEnum::DOFUS_ONE,
					ItemPositionEnum::DOFUS_TWO,
					ItemPositionEnum::DOFUS_THREE,
					ItemPositionEnum::DOFUS_FOUR,
					ItemPositionEnum::DOFUS_FIVE,
					ItemPositionEnum::DOFUS_SIX,
					ItemPositionEnum::SHIELD
				]
			]);
	}
}