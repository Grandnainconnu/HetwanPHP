<?php

/**
 * @Author: jean
 * @Date:   2017-09-16 21:56:45
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-11-03 22:33:36
 */

namespace Hetwan\Entity\Game;


/**
 * @Table(name="items_data")
 * @Entity
 */
class ItemData extends AbstractGameEntity
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="name", type="text", nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @Column(name="effects", type="text", nullable=true)
     */
    private $effects;

    /**
     * @var integer
     *
     * @Column(name="typeId", type="integer", nullable=false)
     */
    private $typeId;

    /**
     * @var integer
     *
     * @Column(name="skinId", type="integer", nullable=false)
     */
    private $skinId;

    /**
     * @var integer
     *
     * @Column(name="level", type="integer", nullable=false)
     */
    private $level;

    /**
     * @var integer
     *
     * @Column(name="weight", type="integer", nullable=false)
     */
    private $weight;

    /**
     * @var boolean
     *
     * @Column(name="canFM", type="boolean", nullable=false)
     */
    private $canFM;

    /**
     * @var boolean
     *
     * @Column(name="usable", type="boolean", nullable=false)
     */
    private $usable;

    /**
     * @var string
     *
     * @Column(name="weaponEffects", type="text", nullable=false)
     */
    private $weaponEffects;

    /**
     * @var string
     *
     * @Column(name="conditions", type="text", nullable=true)
     */
    private $conditions;

    /**
     * @var integer
     *
     * @Column(name="episode", type="integer", nullable=false)
     */
    private $episode;

    /**
     * @var boolean
     *
     * @Column(name="twoHanded", type="boolean", nullable=false)
     */
    private $twoHanded = false;

    /**
     * @var boolean
     *
     * @Column(name="targetable", type="boolean", nullable=false)
     */
    private $targetable;

    /**
     * @var boolean
     *
     * @Column(name="isEthereal", type="boolean", nullable=false)
     */
    private $isEthereal;

    /**
     * @var integer
     *
     * @Column(name="setId", type="integer", nullable=true)
     */
    private $setId = -1;

    /**
     * @var boolean
     *
     * @Column(name="wd", type="boolean", nullable=false)
     */
    private $wd;

    /**
     * @var integer
     *
     * @Column(name="an", type="integer", nullable=true)
     */
    private $an;

    /**
     * @var integer
     *
     * @Column(name="price", type="integer", nullable=true)
     */
    private $price = 0;

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
     * Set name
     *
     * @param string $name
     *
     * @return ItemData
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set effects
     *
     * @param string $effects
     *
     * @return ItemData
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
     * Set typeId
     *
     * @param integer $typeId
     *
     * @return ItemData
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;

        return $this;
    }

    /**
     * Get typeId
     *
     * @return integer
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * Set skinId
     *
     * @param integer $skinId
     *
     * @return ItemData
     */
    public function setSkinId($skinId)
    {
        $this->skinId = $skinId;

        return $this;
    }

    /**
     * Get skinId
     *
     * @return integer
     */
    public function getSkinId()
    {
        return $this->skinId;
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return ItemData
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set weight
     *
     * @param integer $weight
     *
     * @return ItemData
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return integer
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set canFM
     *
     * @param boolean $canFM
     *
     * @return ItemData
     */
    public function setCanFM($canFM)
    {
        $this->canFM = $canFM;

        return $this;
    }

    /**
     * Get canFM
     *
     * @return boolean
     */
    public function getCanFM()
    {
        return $this->canFM;
    }

    /**
     * Set usable
     *
     * @param boolean $usable
     *
     * @return ItemData
     */
    public function setUsable($usable)
    {
        $this->usable = $usable;

        return $this;
    }

    /**
     * Get usable
     *
     * @return boolean
     */
    public function getUsable()
    {
        return $this->usable;
    }

    /**
     * Set weaponEffects
     *
     * @param string $weaponEffects
     *
     * @return ItemData
     */
    public function setWeaponEffects($weaponEffects)
    {
        $this->weaponEffects = $weaponEffects;

        return $this;
    }

    /**
     * Get weaponEffects
     *
     * @return string
     */
    public function getWeaponEffects()
    {
        return $this->weaponEffects;
    }

    /**
     * Set conditions
     *
     * @param string $conditions
     *
     * @return ItemData
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Get conditions
     *
     * @return string
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Set episode
     *
     * @param integer $episode
     *
     * @return ItemData
     */
    public function setEpisode($episode)
    {
        $this->episode = $episode;

        return $this;
    }

    /**
     * Get episode
     *
     * @return integer
     */
    public function getEpisode()
    {
        return $this->episode;
    }

    /**
     * Set twoHanded
     *
     * @param boolean $twoHanded
     *
     * @return ItemData
     */
    public function setTwoHanded($twoHanded)
    {
        $this->twoHanded = $twoHanded;

        return $this;
    }

    /**
     * Get twoHanded
     *
     * @return boolean
     */
    public function getTwoHanded()
    {
        return $this->twoHanded;
    }

    /**
     * Set targetable
     *
     * @param boolean $targetable
     *
     * @return ItemData
     */
    public function setTargetable($targetable)
    {
        $this->targetable = $targetable;

        return $this;
    }

    /**
     * Get targetable
     *
     * @return boolean
     */
    public function getTargetable()
    {
        return $this->targetable;
    }

    /**
     * Set isEthereal
     *
     * @param boolean $isEthereal
     *
     * @return ItemData
     */
    public function setIsEthereal($isEthereal)
    {
        $this->isEthereal = $isEthereal;

        return $this;
    }

    /**
     * Get isEthereal
     *
     * @return boolean
     */
    public function getIsEthereal()
    {
        return $this->isEthereal;
    }

    /**
     * Set setId
     *
     * @param integer $setId
     *
     * @return ItemData
     */
    public function setSetId($setId)
    {
        $this->setId = $setId;

        return $this;
    }

    /**
     * Get setId
     *
     * @return integer
     */
    public function getSetId()
    {
        return $this->setId;
    }

    /**
     * Set wd
     *
     * @param boolean $wd
     *
     * @return ItemData
     */
    public function setWd($wd)
    {
        $this->wd = $wd;

        return $this;
    }

    /**
     * Get wd
     *
     * @return boolean
     */
    public function getWd()
    {
        return $this->wd;
    }

    /**
     * Set an
     *
     * @param integer $an
     *
     * @return ItemData
     */
    public function setAn($an)
    {
        $this->an = $an;

        return $this;
    }

    /**
     * Get an
     *
     * @return integer
     */
    public function getAn()
    {
        return $this->an;
    }

    /**
     * Set price
     *
     * @param integer $price
     *
     * @return ItemData
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return integer
     */
    public function getPrice()
    {
        return $this->price;
    }
}

