<?php

/**
 * @Author: jean
 * @Date:   2017-09-21 23:44:34
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-30 20:16:18
 */

namespace Hetwan\Entity\Game;


trait ItemTrait
{
    /**
     * Get parsed effects
     *
     * @return string
     */
    public function getParsedEffects()
    {
        return \Hetwan\Helper\ItemEffectHelper::getEffectsFromString($this->effects);
    }

    /**
     * @PrePersist
     */
    public function preSave() 
    {
        $this->id = uniqid();
    }

    public function slice($quantity)
    {
        $copy = new Item;

        $copy
            ->setPlayerId($this->getPlayerId())
            ->setItemData($this->getItemData())
            ->setPosition(-1)
            ->setEffects($this->getEffects())
            ->setQuantity($quantity)
            ->save();

        $this->setQuantity($this->getQuantity() - $quantity);

        return $copy;
    }

    public function sliceOne()
    {
        return $this->slice(1);
    }

    // Test functions
    public function equals(Item $item)
    {
        if ($item == $this)
            return true;
        elseif ($item->getItemData()->getId() != $this->getItemData()->getId() || self::sum($item) != self::sum($this))
            return false;
        else
        {
            $toCompareEffects = $item->getParsedEffects();

            foreach ($this->getParsedEffects() as $effectName => $value)
                if (!isset($toCompareEffects[$effectName]) || $toCompareEffects[$effectName] != $value)
                    return false;
        }

        return true;
    }

    public static function sum(Item $item)
    {
        $total = 0;

        foreach ($item->getParsedEffects() as $value)
            $total += (int) $value;

        return $total;
    }
}

/**
 * @Entity 
 * @Table(name="items")
 */
class Item extends AbstractGameEntity
{
    use ItemTrait;

    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue 
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="ItemData")
     * @JoinColumn(name="itemId", referencedColumnName="id")
     */
    protected $itemData;

    /**
     * @Column(type="integer")
     *
     * @var int
     */
    protected $playerId;

    /**
     * @Column(type="integer")
     *
     * @var int
     */
    protected $position;

    /**
     * @Column(type="text")
     *
     * @var string
     */
    protected $effects;

    /**
     * @Column(type="integer")
     *
     * @var int
     */
    protected $quantity;

   /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set playerId
     *
     * @param integer $playerId
     *
     * @return Item
     */
    public function setPlayerId($playerId)
    {
        $this->playerId = $playerId;

        return $this;
    }

    /**
     * Get playerId
     *
     * @return integer
     */
    public function getPlayerId()
    {
        return $this->playerId;
    }

    /**
     * Set position
     *
     * @param integer $position
     *
     * @return Item
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position
     *
     * @return integer
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set effects
     *
     * @param string $effects
     *
     * @return Item
     */
    public function setEffects($effects)
    {
        $this->effects = $effects;

        return $this;
    }

    /**
     * Get effects
     *
     * @return string
     */
    public function getEffects()
    {
        return $this->effects;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Item
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set itemData
     *
     * @param \Hetwan\Entity\Game\ItemData $itemData
     *
     * @return Item
     */
    public function setItemData(\Hetwan\Entity\Game\ItemData $itemData = null)
    {
        $this->itemData = $itemData;

        return $this;
    }

    /**
     * Get itemData
     *
     * @return \Hetwan\Entity\Game\ItemData
     */
    public function getItemData()
    {
        return $this->itemData;
    }
}