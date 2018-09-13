<?php

namespace Hetwan\Entity\Game;


/**
 * @Entity
 * @Table(name="items_data")
 */
class ItemDataEntity
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
     * @Column(type="text", nullable=true)
     */
    private $effects;

    /**
     * @Column(type="integer", nullable=false)
     */
    private $typeId;

    /**
     * @Column(type="integer", nullable=false)
     */
    private $skinId;

    /**
     * @Column(type="integer", nullable=false)
     */
    private $level;

    /**
     * @Column(type="integer", nullable=false)
     */
    private $weight;

    /**
     * @Column(type="boolean", nullable=false)
     */
    private $canFM;

    /**
     * @Column(type="boolean", nullable=false)
     */
    private $usable;

    /**
     * @Column(type="text", nullable=false)
     */
    private $weaponEffects;

    /**
     * @Column(type="text", nullable=true)
     */
    private $conditions;

    /**
     * @Column(type="integer", nullable=false)
     */
    private $episode;

    /**
     * @Column(type="boolean", options={"default":"0"}, nullable=false)
     */
    private $twoHanded;

    /**
     * @Column(type="boolean", nullable=false)
     */
    private $targetable;

    /**
     * @Column(type="boolean", nullable=false)
     */
    private $isEthereal;

    /**
     * @ManyToOne(targetEntity="ItemSetDataEntity", inversedBy="items")
     * @JoinColumn(name="setId", referencedColumnName="id", nullable=true)
     */
    private $set;

    /**
     * @Column(type="boolean", nullable=false)
     */
    private $wd;

    /**
     * @Column(type="integer", nullable=true)
     */
    private $an;

    /**
     * @Column(type="integer", options={"default":"0"}, nullable=true)
     */
    private $price;

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
     * @return ItemDataEntity
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
     * @return ItemDataEntity
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
     * Set typeId.
     *
     * @param int $typeId
     *
     * @return ItemDataEntity
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * Get typeId.
     *
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Set skinId.
     *
     * @param int $skinId
     *
     * @return ItemDataEntity
     */
    public function setSkinId($skinId)
    {
        $this->skinId = $skinId;

        return $this;
    }

    /**
     * Get skinId.
     *
     * @return int
     */
    public function getSkinId()
    {
        return $this->skinId;
    }

    /**
     * Set level.
     *
     * @param int $level
     *
     * @return ItemDataEntity
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level.
     *
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set weight.
     *
     * @param int $weight
     *
     * @return ItemDataEntity
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight.
     *
     * @return int
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set canFM.
     *
     * @param bool $canFM
     *
     * @return ItemDataEntity
     */
    public function setCanFM($canFM)
    {
        $this->canFM = $canFM;

        return $this;
    }

    /**
     * Get canFM.
     *
     * @return bool
     */
    public function getCanFM()
    {
        return $this->canFM;
    }

    /**
     * Set usable.
     *
     * @param bool $usable
     *
     * @return ItemDataEntity
     */
    public function setUsable($usable)
    {
        $this->usable = $usable;

        return $this;
    }

    /**
     * Get usable.
     *
     * @return bool
     */
    public function getUsable()
    {
        return $this->usable;
    }

    /**
     * Set weaponEffects.
     *
     * @param string $weaponEffects
     *
     * @return ItemDataEntity
     */
    public function setWeaponEffects($weaponEffects)
    {
        $this->weaponEffects = $weaponEffects;

        return $this;
    }

    /**
     * Get weaponEffects.
     *
     * @return string
     */
    public function getWeaponEffects()
    {
        return $this->weaponEffects;
    }

    /**
     * Set conditions.
     *
     * @param string|null $conditions
     *
     * @return ItemDataEntity
     */
    public function setConditions($conditions = null)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Get conditions.
     *
     * @return string|null
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Set episode.
     *
     * @param int $episode
     *
     * @return ItemDataEntity
     */
    public function setEpisode($episode)
    {
        $this->episode = $episode;

        return $this;
    }

    /**
     * Get episode.
     *
     * @return int
     */
    public function getEpisode()
    {
        return $this->episode;
    }

    /**
     * Set twoHanded.
     *
     * @param bool $twoHanded
     *
     * @return ItemDataEntity
     */
    public function setTwoHanded($twoHanded)
    {
        $this->twoHanded = $twoHanded;

        return $this;
    }

    /**
     * Get twoHanded.
     *
     * @return bool
     */
    public function getTwoHanded()
    {
        return $this->twoHanded;
    }

    /**
     * Set targetable.
     *
     * @param bool $targetable
     *
     * @return ItemDataEntity
     */
    public function setTargetable($targetable)
    {
        $this->targetable = $targetable;

        return $this;
    }

    /**
     * Get targetable.
     *
     * @return bool
     */
    public function getTargetable()
    {
        return $this->targetable;
    }

    /**
     * Set isEthereal.
     *
     * @param bool $isEthereal
     *
     * @return ItemDataEntity
     */
    public function setIsEthereal($isEthereal)
    {
        $this->isEthereal = $isEthereal;

        return $this;
    }

    /**
     * Get isEthereal.
     *
     * @return bool
     */
    public function getIsEthereal()
    {
        return $this->isEthereal;
    }

    /**
     * Set wd.
     *
     * @param bool $wd
     *
     * @return ItemDataEntity
     */
    public function setWd($wd)
    {
        $this->wd = $wd;

        return $this;
    }

    /**
     * Get wd.
     *
     * @return bool
     */
    public function getWd()
    {
        return $this->wd;
    }

    /**
     * Set an.
     *
     * @param int|null $an
     *
     * @return ItemDataEntity
     */
    public function setAn($an = null)
    {
        $this->an = $an;

        return $this;
    }

    /**
     * Get an.
     *
     * @return int|null
     */
    public function getAn()
    {
        return $this->an;
    }

    /**
     * Set price.
     *
     * @param int|null $price
     *
     * @return ItemDataEntity
     */
    public function setPrice($price = null)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price.
     *
     * @return int|null
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set set.
     *
     * @param \Hetwan\Entity\Game\ItemSetDataEntity|null $set
     *
     * @return ItemDataEntity
     */
    public function setSet(\Hetwan\Entity\Game\ItemSetDataEntity $set = null)
    {
        $this->set = $set;

        return $this;
    }

    /**
     * Get set.
     *
     * @return \Hetwan\Entity\Game\ItemSetDataEntity|null
     */
    public function getSet()
    {
        return $this->set;
    }
}
