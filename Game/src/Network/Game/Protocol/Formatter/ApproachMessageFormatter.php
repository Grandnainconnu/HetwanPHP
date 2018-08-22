<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-23 18:26:50
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-30 17:53:04
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


class ApproachMessageFormatter
{
	public static function helloGameMessage()
	{
		return 'HG';
	}

	public static function regionalVersionResponseMessage($community)
	{
		return 'AV' . $community;
	}

	public static function playerSelectionMessage($player)
	{

		$packet = [
			'ASK',
			$player->getId(),
			$player->getName(),
			$player->getLevel(),
			$player->getFaction(),
			$player->getGender(),
			$player->getSkinId(),
			preg_replace('/;/', '|', $player->getColors())
		];

		$itemsPacket = [];

		foreach (array_merge($player->getInventoryItems(), $player->getEquipedItems()) as $item)
			$itemsPacket[] = ItemMessageFormatter::itemFormatter($item);

		return implode('|', $packet) . '|' . implode(';', $itemsPacket);
	}

	public static function boostCharacteristicErrorMessage()
	{
		return 'ABE';
	}
}