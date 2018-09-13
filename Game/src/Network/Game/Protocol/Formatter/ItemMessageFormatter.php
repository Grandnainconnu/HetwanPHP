<?php

namespace Hetwan\Network\Game\Protocol\Formatter;

use Hetwan\Helper\ItemHelper;
use Hetwan\Network\Game\Protocol\Enum\ItemPositionEnum;


class ItemMessageFormatter
{
	public static function itemFormatter($item)
	{
		return dechex($item->getId()) . '~' . dechex($item->getItemData()->getId()) . '~' . $item->getQuantity() . '~' . (($item->getPosition() < 0) ? $item->getPosition() : dechex($item->getPosition())) . '~' . $item->getEffects();
	}

	public static function inventoryStatsMessage($pods, $maxPods)
	{
		return 'Ow' . $pods . '|' . $maxPods;
	}

	public static function itemConditionsNotFilledMessage()
	{
		return 'Im119|43';
	}

	public static function itemLevelTooHighMessage()
	{
		return 'OAEL';
	}

	public static function quantityMessage($itemId, $quantity) 
	{
        return 'OQ' . $itemId . '|' . $quantity;
    }

    public static function deleteMessage($itemId) 
    {
        return 'OR' . $itemId;
    }

    public static function addItemMessage($item) 
    {
        return 'OAKO' . self::itemFormatter($item);
    }

    public static function itemMovementMessage($itemId, $position)
    {
        return 'OM' . $itemId . '|' . ($position == \Hetwan\Network\Game\Protocol\Enum\ItemPositionEnum::INVENTORY ? '' : $position);
    }

    public static function accessoriesMessage(\Hetwan\Entity\Game\PlayerEntity $player) : string
    {
    	return 'Oa' . $player->getId() . '|' . ItemHelper::formatAccessories(ItemHelper::getWithPositions(ItemPositionEnum::ACCESSORY, $player->getItems()));
    }
}