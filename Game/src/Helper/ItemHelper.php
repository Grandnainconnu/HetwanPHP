<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-25 23:52:24
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-31 15:20:23
 */

namespace Hetwan\Helper;

use Hetwan\Network\Game\Protocol\Enum\ItemPositionEnum;
use Hetwan\Network\Game\Protocol\Enum\ItemTypeEnum;


class ItemHelper extends AbstractHelper
{
	public static function generateItem($itemId, $perfectEffects = false)
	{
		$item = null;
		$itemData = self::getGameEntityManager()
			->getRepository('\Hetwan\Entity\Game\ItemData')
			->findOneById($itemId);

		if ($itemData != null)
		{
			$item = new \Hetwan\Entity\Game\Item;

			$item
				->setItemData($itemData)
				->setPosition(ItemPositionEnum::INVENTORY)
				->setQuantity(1)
				->setEffects(
					ItemEffectHelper::toString(ItemEffectHelper::generateEffectsFromString($itemData->getEffects(), $perfectEffects))
				);
		}

		return $item;
	}

	public static function getPlayerInventoryItems($playerId)
	{
		return self::getGameEntityManager()
			->getRepository('\Hetwan\Entity\Game\Item')
			->findBy([
				'playerId' => $playerId,
				'position' => ItemPositionEnum::INVENTORY
			]);
	}

	public static function getPlayerTakenPods($player)
	{
		$takenPods = 0;

		foreach (array_merge($player->getInventoryItems(), $player->getEquipedItems()) as $item)
			$takenPods += $item->getItemData()->getWeight();

		return $takenPods;
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
					ItemPositionEnum::BELT,
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

	public static function getPlayerItem($playerItems, $itemId)
	{
		foreach ($playerItems as $item)
			if ($itemId == $item->getId())
				return $item;
	}

	public static function getPlayerItemsWithPosition($playerItems, $position)
	{
		foreach ($playerItems as $item)
			if ($item->getPosition() == $position)
				return $item;
	}

	public static function validMovementWithTypeId($typeId, $position)
	{
		switch ($position)
		{
			case ItemPositionEnum::AMULET:
				return $typeId == ItemTypeEnum::AMULET;
			case ItemPositionEnum::BELT:
				return $typeId == ItemTypeEnum::BELT;
			case ItemPositionEnum::BOOTS:
				return $typeId == ItemTypeEnum::BOOT;
			case ItemPositionEnum::MANTLE:
				return $typeId == ItemTypeEnum::CLOAK;
			case ItemPositionEnum::DOFUS_ONE:
			case ItemPositionEnum::DOFUS_TWO:
			case ItemPositionEnum::DOFUS_THREE:
			case ItemPositionEnum::DOFUS_FOUR:
			case ItemPositionEnum::DOFUS_FIVE:
			case ItemPositionEnum::DOFUS_SIX:
				return $typeId == ItemTypeEnum::DOFUS;
			case ItemPositionEnum::CAP:
				return $typeId == ItemTypeEnum::HAT;
			case ItemPositionEnum::RING_ONE:
			case ItemPositionEnum::RING_TWO:
				return $typeId == ItemTypeEnum::RING;
			case ItemPositionEnum::ANIMAL:
				return $typeId == ItemTypeEnum::PET;
			case ItemPositionEnum::SHIELD:
				return $typeId ==  ItemTypeEnum::SHIELD;
			case ItemPositionEnum::WEAPON:
				return ItemTypeEnum::isWeapon($typeId);
			default:
				return true;
		}
	}

	public static function validMovementWithItem($player, $item, $position)
	{
		if (!self::validMovementWithTypeId($item->getItemData()->getTypeId(), $position))
			return false;
		elseif ($item->getItemData()->getTypeId() == ItemTypeEnum::RING && $position != ItemPositionEnum::INVENTORY)
		{
			$otherPosition = $position == ItemPositionEnum::RING_ONE ? ItemPositionEnum::RING_TWO : ItemPositionEnum::RING_ONE;
			$otherRing = self::getPlayerItemsWithPosition($player->getEquipedItems(), $otherPosition);

			if ($otherRing != null)
				return $otherRing->getItemData()->getId() != $item->getItemData()->getId();
		}

		return true;
	}

	public static function getPlayerSameItem($playerItems, $item)
	{
		foreach ($playerItems as $cItem)
			if ($cItem->getPosition() == ItemPositionEnum::INVENTORY && $cItem->equals($item))
				return $cItem;
	}
}