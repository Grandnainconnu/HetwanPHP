<?php

namespace Hetwan\Helper;

use Hetwan\Entity\Game\{
    ItemEntity,
    ItemDataEntity
};
use Hetwan\Network\Game\Protocol\Enum\ItemPositionEnum;
use Hetwan\Network\Game\Protocol\Enum\ItemTypeEnum;


final class ItemHelper
{
	/**
	 * @Inject
	 * @var \Hetwan\Core\EntityManager
	 */
	private $entityManager;

	public function generate(int $itemId, int $quantity = 1, bool $perfectEffects = false) : ?\Hetwan\Entity\Game\ItemEntity
	{
		$item = null;
		$itemData = $this->entityManager->get()
						                ->getRepository(ItemDataEntity::class)
						                ->findOneById($itemId);

		if ($itemData !== null) {
			$item = new ItemEntity;

			$item->setItemData($itemData)
				 ->setPosition(ItemPositionEnum::INVENTORY)
				 ->setQuantity($quantity)
				 ->setEffects(ItemEffectHelper::toString(ItemEffectHelper::generateFromString($itemData->getEffects(), $perfectEffects)));
		}

		return $item;
	}

    public static function formatAccessories(array $accessoriesItems) : string
    {
        $positionedAccessories = array_flip(ItemPositionEnum::ACCESSORY);

        foreach ($positionedAccessories as &$value) {
            $value = null;
        }

        foreach ($accessoriesItems as $accessory) {
            $positionedAccessories[$accessory->getPosition()] = dechex($accessory->getItemData()->getId());
        }

        return ',' . implode(',', $positionedAccessories);
    }

    public static function validMove(\Hetwan\Entity\Game\ItemEntity $item, int $position, iterable $equipedItems) : bool
    {
        if (!self::validMoveWithTypeId($item->getItemData()->getTypeId(), $position)) {
            return false;
        } elseif ($item->getItemData()->getTypeId() === ItemTypeEnum::RING and $position !== ItemPositionEnum::INVENTORY) {
            $otherPosition = $position === ItemPositionEnum::RING_ONE ? ItemPositionEnum::RING_TWO : ItemPositionEnum::RING_ONE;
            $otherRing = self::getWithPosition($otherPosition, $equipedItems);

            if (!empty($otherRing)) {
                return $otherRing[0]->getItemData()->getId() !== $item->getItemData()->getId();
            }
        }

        return true;
    }

    public static function validMoveWithTypeId(int $typeId, int $position) : bool
    {
        switch ($position) {
            case ItemPositionEnum::AMULET:
                return $typeId === ItemTypeEnum::AMULET;
            case ItemPositionEnum::BELT:
                return $typeId === ItemTypeEnum::BELT;
            case ItemPositionEnum::BOOTS:
                return $typeId === ItemTypeEnum::BOOT;
            case ItemPositionEnum::MANTLE:
                return $typeId === ItemTypeEnum::CLOAK;
            case ItemPositionEnum::DOFUS_ONE:
            case ItemPositionEnum::DOFUS_TWO:
            case ItemPositionEnum::DOFUS_THREE:
            case ItemPositionEnum::DOFUS_FOUR:
            case ItemPositionEnum::DOFUS_FIVE:
            case ItemPositionEnum::DOFUS_SIX:
                return $typeId === ItemTypeEnum::DOFUS;
            case ItemPositionEnum::CAP:
                return $typeId === ItemTypeEnum::HAT;
            case ItemPositionEnum::RING_ONE:
            case ItemPositionEnum::RING_TWO:
                return $typeId === ItemTypeEnum::RING;
            case ItemPositionEnum::ANIMAL:
                return $typeId === ItemTypeEnum::PET;
            case ItemPositionEnum::SHIELD:
                return $typeId ===  ItemTypeEnum::SHIELD;
            case ItemPositionEnum::WEAPON:
                return ItemTypeEnum::isWeapon($typeId);
            default:
                return true;
        }
    }

    public static function slice(\Hetwan\Entity\Game\ItemEntity &$item, int $quantity) : \Hetwan\Entity\Game\ItemEntity
    {
        $copy = new ItemEntity;
        $copy->setItemData($item->getItemData())
             ->setPlayer($item->getPlayer())
             ->setPosition(ItemPositionEnum::INVENTORY)
             ->setEffects($item->getEffects())
             ->setQuantity($quantity);

        $item->setQuantity($item->getQuantity() - $quantity);

        return $copy;
    }

    public static function sliceOne(\Hetwan\Entity\Game\ItemEntity $item) : \Hetwan\Entity\Game\ItemEntity
    {
        return ItemHelper::slice($item, 1);
    }

    public static function equals(\Hetwan\Entity\Game\ItemEntity $a, \Hetwan\Entity\Game\ItemEntity $b) : bool
    {
        $toReturn = true;

        if ($a === $b) {
            return true;
        } elseif ($a->getItemData()->getId() !== $b->getItemData()->getId() or self::sumEffects($a) !== self::sumEffects($b)) {
            return false;
        } else {
            $toCompareEffects = $b->getParsedEffects();
            $effects = $a->getParsedEffects();

            foreach ($effects as $effectName => $value) {
                if (!isset($toCompareEffects[$effectName]) or $toCompareEffects[$effectName] !== $value) {
                    $toReturn = false;

                    break;
                }
            }

            unset($toCompareEffects);
            unset($effects);
        }

        return $toReturn;
    }

    public static function sumEffects(\Hetwan\Entity\Game\ItemEntity $item) : int
    {
        $total = 0;
        $effects = $item->getParsedEffects();

        foreach ($effects as $value) {
            $total += $value;
        }

        unset($effects);

        return $total;
    }

	public static function get(int $itemId, iterable $items) : ?\Hetwan\Entity\Game\ItemEntity
    {
		foreach ($items as $item) {
			if ($item->getId() === $itemId) {
				return $item;
            }
        }

        return null;
	}

	public static function getWithPosition(int $position, iterable $items) : array
	{
	    $itemsWithPosition = [];

		foreach ($items as $item) {
            if ($item->getPosition() === $position) {
                $itemsWithPosition[] = $item;
            }
        }

        return $itemsWithPosition;
	}

    public static function getWithPositions(array $positions, iterable $items) : array
    {
        $itemsWithPositions = [];

        foreach ($items as $item) {
            if (in_array($item->getPosition(), $positions)) {
                $itemsWithPositions[] = $item;
            }
        }

        return $itemsWithPositions;
    }

	public static function getSame(\Hetwan\Entity\Game\ItemEntity $item, iterable $items, int $desiredPosition = ItemPositionEnum::INVENTORY) : ?\Hetwan\Entity\Game\ItemEntity
	{
		foreach ($items as $itemIt) {
            if ($itemIt->getPosition() == $desiredPosition and self::equals($item, $itemIt)) {
                return $itemIt;
            }
        }

        return null;
	}

	public static function getDiff(array $a, array $b) : array
    {
        $diffs = [
            'append' => [],
            'move' => [],
            'unmove' => []
        ];

        foreach ($a as $item) {
            if (in_array($item, $b)) {
                $diffs['unmove'][] = $item;

                unset($b[array_search($item, $b)]);
            } else {
                $diffs['move'][] = $item;
            }
        }

        $diffs['append'] = $b;

        return $diffs;
    }
}