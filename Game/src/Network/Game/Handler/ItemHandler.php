<?php

/**
 * @Author: jeanw
 * @Date:   2017-11-03 14:01:59
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-31 15:08:52
 */

namespace Hetwan\Network\Game\Handler;

use Hetwan\Helper\ItemHelper;
use Hetwan\Helper\MapDataHelper;
use Hetwan\Helper\Condition\ConditionHelper;

use Hetwan\Network\Game\Protocol\Formatter\ItemMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\GameMessageFormatter;

use Hetwan\Network\Game\Protocol\Enum\ItemPositionEnum;


class ItemHandler extends AbstractGameHandler
{
	public function handle($data)
	{
		switch (substr($data, 0, 1))
		{
			case 'M':
				list($itemId, $position) = explode('|', substr($data, 1));
				
				$this->moveItem($itemId, $position);
				$this->checkEquipedItemsConditions(); // To prevent keeped items without filled conditions

				break;
			default:
				echo "Unable to handle item packet: {$data}\n";

				break;
		}
	}

	private function checkEquipedItemsConditions()
	{
		foreach ($this->getPlayer()->getEquipedItems() as $item)
			if (!ConditionHelper::playerFillItemConditions($item->getItemData()->getConditions(), $this->getPlayer()))
				$this->moveItem($item->getId(), ItemPositionEnum::INVENTORY, $force = true);
	}

	private function moveItem($itemId, $position, $force = false)
	{
		$playerItems = array_merge($this->getPlayer()->getInventoryItems(), $this->getPlayer()->getEquipedItems());

		if (($item = ItemHelper::getPlayerItem($playerItems, $itemId)) == null || $item->getQuantity() < 1 || $item->getPosition() == $position || !ItemHelper::validMovementWithItem($this->getPlayer(), $item, $position))
			return;
		elseif ($this->getPlayer()->getLevel() < $item->getItemData()->getLevel())
			$this->send(ItemMessageFormatter::itemLevelTooHighMessage());
		elseif (!ConditionHelper::playerFillItemConditions($item->getItemData()->getConditions(), $this->getPlayer()) && !$force)
			$this->send(ItemMessageFormatter::itemConditionsNotFilledMessage());
		else
		{
			if ($position == ItemPositionEnum::INVENTORY && ($sameItem = ItemHelper::getPlayerSameItem($playerItems, $item)))
			{
				// Append one item to the quantity
				$sameItem->setQuantity($sameItem->getQuantity() + 1);

				$this->send(ItemMessageFormatter::deleteMessage($item->getId()));				
				$this->send(ItemMessageFormatter::quantityMessage($sameItem->getId(), $sameItem->getQuantity()));

				$item->remove();
				$sameItem->save();
			}
			else
			{
				if (($itemAlreadyHere = ItemHelper::getPlayerItemsWithPosition($playerItems, $position)))
					$this->moveItem($itemAlreadyHere->getId(), ItemPositionEnum::INVENTORY);

				if ($item->getQuantity() > 1)
				{
					$copy = $item->sliceOne();

					$this->send(ItemMessageFormatter::addItemMessage($copy));
					$this->send(ItemMessageFormatter::quantityMessage($item->getId(), $item->getQuantity()));

					$item = $copy;
				}

				$item
					->setPosition($position)
					->save();

				$this->send(ItemMessageFormatter::itemMovementMessage($item->getId(), $item->getPosition()));
			}
		}

		// Update inventory and equiped items
		$this->getPlayer()->refreshInventoryItems();
		$this->getPlayer()->refreshEquipedItems();

		// Update player bonus
		$this->getPlayer()->getCharacteristics()->updateCharacteristicsBonus($this->getPlayer()->getEquipedItemsBonus());

		$this->send(ItemMessageFormatter::inventoryStatsMessage(
			$this->getPlayer()->getCharacteristics()->getCharacteristic('pods')->getCurrent(),
			$this->getPlayer()->getCharacteristics()->getCharacteristic('pods')->getTotal()
		));

		$this->send(GameMessageFormatter::playerStatisticsMessage($this->getPlayer()));

		if (in_array($position, [ItemPositionEnum::CAP, ItemPositionEnum::MANTLE, ItemPositionEnum::ANIMAL, ItemPositionEnum::SHIELD]))
			MapDataHelper::updatePlayerAccessoriesInMap($this->getPlayer()); // Update player in map
	}
}