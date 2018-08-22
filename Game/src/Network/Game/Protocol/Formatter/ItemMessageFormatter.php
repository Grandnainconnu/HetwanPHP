<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-26 23:10:11
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-31 14:07:12
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


class ItemMessageFormatter
{
	public static function itemFormatter($item)
	{
		$convertedItemId = dechex($item->getId());
		$convertedTemplateId = dechex($item->getItemData()->getId());

		return "{$convertedItemId}~{$convertedTemplateId}~{$item->getQuantity()}~{$item->getPosition()}~{$item->getEffects()}";
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

    public static function accessoriesMessage($player)
    {
    	return 'Oa' . $player->getId() . '|' . \Hetwan\Helper\Player\PlayerHelper::getPlayerAccessories($player);
    }
}