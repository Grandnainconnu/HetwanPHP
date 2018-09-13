<?php

namespace Hetwan\Entity\Game;

use Hetwan\Helper\ItemEffectHelper;


/**
 * @Entity
 * @Table(name="items")
 * @HasLifecycleCallbacks
 */
class ItemEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="PlayerEntity", inversedBy="items")
     * @JoinColumn(name="playerId", referencedColumnName="id", nullable=true)
     */
    private $player;

    /**
     * @ManyToOne(targetEntity="PlayerEntity", inversedBy="storeItems")
     * @JoinColumn(name="storePlayerId", referencedColumnName="id", nullable=true)
     */
    private $storePlayer;

    /**
     * @ManyToOne(targetEntity="ItemDataEntity")
     * @JoinColumn(name="itemId", referencedColumnName="id", nullable=false)
     */
    private $itemData;

    /**
     * @Column(type="integer")
     */
    private $playerId;

    /**
     * @Column(type="integer")
     */
    private $position;

    /**
     * @Column(type="text")
     */
    protected $effects;

    /**
     * @Column(type="integer")
     */
    private $quantity;

    /**
     * @var array
     */
    private $parsedEffects;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set playerId.
     *
     * @param int $playerId
     *
     * @return ItemEntity
     */
    public function setPlayerId($playerId)
    {
        $this->playerId = $playerId;

        return $this;
    }

    /**
     * Get playerId.
     *
     * @return int
     */
    public function getPlayerId()
    {
        return $this->playerId;
    }

    /**
     * Set position.
     *
     * @param int $position
     *
     * @return ItemEntity
     */
    public function setPosition($position)
    {
        $this->position = $position;

        return $this;
    }

    /**
     * Get position.
     *
     * @return int
     */
    public function getPosition()
    {
        return $this->position;
    }

    /**
     * Set effects.
     *
     * @param string $effects
     *
     * @return ItemEntity
     */
    public function setEffects($effects)
    {
        $this->effects = $effects;

        return $this;
    }

    /**
     * Get effects.
     *
     * @return string
     */
    public function getEffects()
    {
        return $this->effects;
    }

    /**
     * Set quantity.
     *
     * @param int $quantity
     *
     * @return ItemEntity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity.
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set player.
     *
     * @param \Hetwan\Entity\Game\PlayerEntity|null $player
     *
     * @return ItemEntity
     */
    public function setPlayer(\Hetwan\Entity\Game\PlayerEntity $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player.
     *
     * @return \Hetwan\Entity\Game\PlayerEntity|null
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set storePlayer.
     *
     * @param \Hetwan\Entity\Game\PlayerEntity|null $storePlayer
     *
     * @return ItemEntity
     */
    public function setStorePlayer(\Hetwan\Entity\Game\PlayerEntity $storePlayer = null)
    {
        $this->storePlayer = $storePlayer;

        return $this;
    }

    /**
     * Get storePlayer.
     *
     * @return \Hetwan\Entity\Game\PlayerEntity|null
     */
    public function getStorePlayer()
    {
        return $this->storePlayer;
    }

    /**
     * Set itemData.
     *
     * @param \Hetwan\Entity\Game\ItemDataEntity $itemData
     *
     * @return ItemEntity
     */
    public function setItemData(\Hetwan\Entity\Game\ItemDataEntity $itemData)
    {
        $this->itemData = $itemData;

        return $this;
    }

    /**
     * Get itemData.
     *
     * @return \Hetwan\Entity\Game\ItemDataEntity
     */
    public function getItemData()
    {
        return $this->itemData;
    }

    /* POST GENERATION METHODS */

    /**
     * Update items parsed effects
     */
    public function updateParsedEffects() : void
    {
        $this->parsedEffects = ItemEffectHelper::getFromString($this->effects);
    }

    /**
     * Get item parsed effects
     *
     * @param bool $update
     * @return array
     */
    public function getParsedEffects(bool $update = false) : array
    {
        if ($update === true or $this->parsedEffects === null) {
            $this->updateParsedEffects();
        }

        return $this->parsedEffects;
    }
}
