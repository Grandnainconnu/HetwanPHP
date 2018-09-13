<?php

namespace Hetwan\Entity\Game;


/**
 * @Entity
 * @Table(name="itemsets_data")
 */
class ItemSetDataEntity
{
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @Column(type="text", nullable=false)
     */
    private $name;

    /**
     * @OneToMany(targetEntity="ItemDataEntity", mappedBy="set")
     */
    private $items;

    /**
     * @var string
     *
     * @Column(name="effects", type="text", nullable=true)
     */
    private $effects;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set name.
     *
     * @param string $name
     *
     * @return ItemSetDataEntity
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set effects.
     *
     * @param string|null $effects
     *
     * @return ItemSetDataEntity
     */
    public function setEffects($effects = null)
    {
        $this->effects = $effects;

        return $this;
    }

    /**
     * Get effects.
     *
     * @return string|null
     */
    public function getEffects()
    {
        return $this->effects;
    }

    /**
     * Add item.
     *
     * @param \Hetwan\Entity\Game\ItemDataEntity $item
     *
     * @return ItemSetDataEntity
     */
    public function addItem(\Hetwan\Entity\Game\ItemDataEntity $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item.
     *
     * @param \Hetwan\Entity\Game\ItemDataEntity $item
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeItem(\Hetwan\Entity\Game\ItemDataEntity $item)
    {
        return $this->items->removeElement($item);
    }

    /**
     * Get items.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }
}
