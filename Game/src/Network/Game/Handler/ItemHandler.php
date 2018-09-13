<?php

namespace Hetwan\Network\Game\Handler;

use Hetwan\Entity\Game\Base\Item;
use Hetwan\Helper\ItemHelper;
use Hetwan\Network\Game\Base\Handler\HandlerTrait;
use Hetwan\Network\Game\Protocol\Enum\ItemPositionEnum;
use Hetwan\Network\Game\Protocol\Formatter\{
    ItemMessageFormatter,
    GameMessageFormatter
};


class ItemHandler extends \Hetwan\Network\Base\Handler\Handler
{
	use HandlerTrait;

    /**
     * @Inject
     * @var \Hetwan\Helper\Condition\ConditionHelper
     */
    private $conditionHelper;

    /**
     * @Inject
     * @var \Hetwan\Helper\ExperienceDataHelper
     */
    private $experienceDataHelper;

    /**
     * @Inject
     * @var \Hetwan\Helper\MapDataHelper
     */
    private $mapDataHelper;

	public function handle(string $data) : bool
	{
		switch ($data[0]) {
			case 'M':
				list($itemId, $position) = explode('|', substr($data, 1));

				$this->moveItem($itemId, $position);
				$this->checkEquipedItemsConditions(); // To prevent keeped items without filled conditions

				break;
			default:
			    $this->logger->debug('Unable to handle item packet: ' . $data . PHP_EOL);

				break;
		}

		return true;
	}

	private function checkEquipedItemsConditions() : void
	{
	    $equipedItems = ItemHelper::getWithPositions(ItemPositionEnum::EQUPMENT, $this->getPlayer()->getItems());

		foreach ($equipedItems as $item) {
            if (!$this->conditionHelper->fill($item->getItemData()->getConditions(), $this->getPlayer())) {
                $this->moveItem($item->getId(), ItemPositionEnum::INVENTORY, true);
            }
        }
	}

	private function moveItem(int $itemId, int $position, bool $force = false) : void
	{
	    $previousEquipedItems = ItemHelper::getWithPositions(ItemPositionEnum::EQUPMENT, $this->getPlayer()->getItems());

		if (($item = ItemHelper::get($itemId, $this->getPlayer()->getItems())) === null or
            $item->getQuantity() < 1 or
            $item->getPosition() === $position or
            !ItemHelper::validMove($item, $position, $previousEquipedItems)
        ) {
            return;
        } elseif ($this->getPlayer()->getLevel() < $item->getItemData()->getLevel()) {
            $this->send(ItemMessageFormatter::itemLevelTooHighMessage());
        } elseif (!$this->conditionHelper->fill($item->getItemData()->getConditions(), $this->getPlayer()) and !$force) {
            $this->send(ItemMessageFormatter::itemConditionsNotFilledMessage());
        } else {
			if ($position === ItemPositionEnum::INVENTORY and ($sameItem = ItemHelper::getSame($item, $this->getPlayer()->getItems()))) {
				$this->duplicateItem($item, $sameItem);
			} else {
			    if (!empty(($itemAlreadyHere = ItemHelper::getWithPosition($position, $this->getPlayer()->getItems())))) {
			        if (!ItemHelper::equals($item, $itemAlreadyHere[0])) {
                        $this->moveItem($itemAlreadyHere[0]->getId(), ItemPositionEnum::INVENTORY, false);
                    }
                }

				if ($item->getQuantity() > 1) {
				    $item = $this->cloneItem($item);
                }

				$this->send(ItemMessageFormatter::itemMovementMessage($item->getId(), $position));
			}
		}

        $previousPosition = $item->getPosition();
		$item->setPosition($position);

		$diffs = ItemHelper::getDiff($previousEquipedItems, ItemHelper::getWithPositions(ItemPositionEnum::EQUPMENT, $this->getPlayer()->getItems()));

		// Update player characteristics
		$this->getPlayer()->getCharacteristics()->updateCharacteristicsBonus($diffs['append']);
        $this->getPlayer()->getCharacteristics()->updateCharacteristicsBonus($diffs['move'], true);

        $this->send(ItemMessageFormatter::inventoryStatsMessage(
            $this->getPlayer()->getCharacteristics()->getCharacteristic('pods')->getCurrent(),
            $this->getPlayer()->getCharacteristics()->getCharacteristic('pods')->getTotal()
        ));

        $this->send(GameMessageFormatter::playerStatisticsMessage(
            $this->getPlayer(),
            $this->experienceDataHelper->getWithLevel($this->getPlayer()->getLevel())
        ));

        if (in_array((($position == ItemPositionEnum::INVENTORY) ? $previousPosition : $position), ItemPositionEnum::ACCESSORY)) {
            $this->mapDataHelper->sendToAllPlayers(
                $this->getPlayer()->getMapId(),
                ItemMessageFormatter::accessoriesMessage($this->getPlayer())
            );
        }
	}

	private function cloneItem(\Hetwan\Entity\Game\ItemEntity $item) : \Hetwan\Entity\Game\ItemEntity
    {
        $copy = ItemHelper::sliceOne($item);

        // Register in database

        $this->entityManager->persist($copy);
        $this->entityManager->get()->flush($copy);

        $this->getPlayer()->addItem($copy);

        $this->send(ItemMessageFormatter::addItemMessage($copy));
        $this->send(ItemMessageFormatter::quantityMessage($item->getId(), $item->getQuantity()));

        return $copy;
    }

	private function duplicateItem(\Hetwan\Entity\Game\ItemEntity $item, \Hetwan\Entity\Game\ItemEntity $same) : void
    {
        $same->setQuantity($same->getQuantity() + 1);

        $this->getPlayer()->removeItem($item);

        $this->send(ItemMessageFormatter::deleteMessage($item->getId()));
        $this->send(ItemMessageFormatter::quantityMessage($same->getId(), $same->getQuantity()));

        $this->entityManager->remove($item);
    }
}