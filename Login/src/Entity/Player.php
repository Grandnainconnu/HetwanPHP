<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 19:01:40
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 12:11:38
 */

namespace Hetwan\Entity;

/**
 * TODO : (repositoryClass="Hetwan\Repository\PlayerRepository")
 * @Entity
 * @Table(name="players")
 **/
class Player
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue 
     */
    protected $id;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $serverId;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $name;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $breed;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $gender;

    /**
     * @Column(type="string")
     * @var string
     */
    protected $colors;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $level;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $skinId;

    /**
     * @Column(type="boolean", options={"default":"0"})
     * @var boolean
     */
    protected $isMerchant = false;

    /**
     * @Column(type="boolean", options={"default":"0"})
     * @var boolean
     */
    protected $isDead = false;

    /**
     * @Column(type="integer", options={"default":"0"})
     * @var int
     */
    protected $deathCount = 0;

    /**
     * @Column(type="integer", nullable=true)
     * @var int
     */
    protected $cellId;

    /**
     * @Column(type="integer", nullable=true)
     * @var int
     */
    protected $mapId;

    /**
     * @Column(type="integer", options={"default":"10000"})
     * @var int
     */
    protected $energy = 10000;

    /**
     * @Column(type="integer", options={"default":"0"})
     * @var int
     */
    protected $experience = 0;

    /**
     * @Column(type="integer", options={"default":"3"})
     * @var int
     */
    protected $spellPoints = 3;

    /**
     * @Column(type="integer", options={"default":"5"})
     * @var int
     */
    protected $pointsOfCharacteristics = 5;

    /**
     * @Column(type="integer", options={"default":"0"})
     * @var int
     */
    protected $kamas = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     * @var int
     */
    protected $baseVitality = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     * @var int
     */
    protected $vitality = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     * @var int
     */
    protected $baseWisdom = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     * @var int
     */
    protected $wisdom = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     * @var int
     */
    protected $baseStrength = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     * @var int
     */
    protected $strength = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     * @var int
     */
    protected $baseIntelligence = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     * @var int
     */
    protected $intelligence = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     * @var int
     */
    protected $baseChance = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     * @var int
     */
    protected $chance = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     * @var int
     */
    protected $baseAgility = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     * @var int
     */
    protected $agility = 0;

    /**
     * @Column(type="integer", options={"default": "0"})
     * @var int
     */
    protected $lifePoints = 0;

    /**
     * @Column(type="integer", options={"default": "0"})
     * @var int
     */
    protected $maximumLifePoints = 0;

    /**
     * @Column(type="integer", options={"default": "-1"})
     * @var int
     */
    protected $faction;

    /**
     * @Column(type="integer", options={"default": "0"})
     * @var int
     */
    protected $factionHonorPoints;

    /**
     * @Column(type="integer", nullable=true)
     * @var int
     */
    protected $guildId;

    /**
     * @ManyToOne(targetEntity="Account", inversedBy="players")
     * @JoinColumn(name="accountId", referencedColumnName="id")
     */
    protected $account;

    /**
     * @var array
     */
    protected $equipedItems;

    /**
     * @var array
     */
    protected $inventory;

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
     * Set serverId
     *
     * @param integer $serverId
     *
     * @return Player
     */
    public function setServerId($serverId)
    {
        $this->serverId = $serverId;

        return $this;
    }

    /**
     * Get serverId
     *
     * @return integer
     */
    public function getServerId()
    {
        return $this->serverId;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Player
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
     * Set breed
     *
     * @param integer $breed
     *
     * @return Player
     */
    public function setBreed($breed)
    {
        $this->breed = $breed;

        return $this;
    }

    /**
     * Get breed
     *
     * @return integer
     */
    public function getBreed()
    {
        return $this->breed;
    }

    /**
     * Set gender
     *
     * @param integer $gender
     *
     * @return Player
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return integer
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set colors
     *
     * @param string $colors
     *
     * @return Player
     */
    public function setColors($colors)
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * Get colors
     *
     * @return string
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * Get converted colors
     *
     * @return string
     */
    public function getConvertedColors($separator = ';')
    {
        $colors = [];

        foreach (explode(';', $this->colors) as $color)
            $colors[] = $color != '-1' ? dechex($color) : $color;

        return implode($separator, $colors);
    }

    /**
     * Set level
     *
     * @param integer $level
     *
     * @return Player
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
     * Set skinId
     *
     * @param integer $skinId
     *
     * @return Player
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
     * Set isMerchant
     *
     * @param boolean $isMerchant
     *
     * @return Player
     */
    public function setIsMerchant($isMerchant)
    {
        $this->isMerchant = $isMerchant;

        return $this;
    }

    /**
     * Get isMerchant
     *
     * @return boolean
     */
    public function getIsMerchant()
    {
        return $this->isMerchant;
    }

    /**
     * Set isDead
     *
     * @param boolean $isDead
     *
     * @return Player
     */
    public function setIsDead($isDead)
    {
        $this->isDead = $isDead;

        return $this;
    }

    /**
     * Get isDead
     *
     * @return boolean
     */
    public function getIsDead()
    {
        return $this->isDead;
    }

    /**
     * Set deathCount
     *
     * @param integer $deathCount
     *
     * @return Player
     */
    public function setDeathCount($deathCount)
    {
        $this->deathCount = $deathCount;

        return $this;
    }

    /**
     * Get deathCount
     *
     * @return integer
     */
    public function getDeathCount()
    {
        return $this->deathCount;
    }

    /**
     * Set cellId
     *
     * @param integer $cellId
     *
     * @return Player
     */
    public function setCellId($cellId)
    {
        $this->cellId = $cellId;

        return $this;
    }

    /**
     * Get cellId
     *
     * @return integer
     */
    public function getCellId()
    {
        return $this->cellId;
    }

    /**
     * Set mapId
     *
     * @param integer $mapId
     *
     * @return Player
     */
    public function setMapId($mapId)
    {
        $this->mapId = $mapId;

        return $this;
    }

    /**
     * Get mapId
     *
     * @return integer
     */
    public function getMapId()
    {
        return $this->mapId;
    }

    /**
     * Set energy
     *
     * @param integer $energy
     *
     * @return Player
     */
    public function setEnergy($energy)
    {
        $this->energy = $energy;

        return $this;
    }

    /**
     * Get energy
     *
     * @return integer
     */
    public function getEnergy()
    {
        return $this->energy;
    }

    /**
     * Set experience
     *
     * @param integer $experience
     *
     * @return Player
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * Get experience
     *
     * @return integer
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set spellPoints
     *
     * @param integer $spellPoints
     *
     * @return Player
     */
    public function setSpellPoints($spellPoints)
    {
        $this->spellPoints = $spellPoints;

        return $this;
    }

    /**
     * Get spellPoints
     *
     * @return integer
     */
    public function getSpellPoints()
    {
        return $this->spellPoints;
    }

    /**
     * Set pointsOfCharacteristics
     *
     * @param integer $pointsOfCharacteristics
     *
     * @return Player
     */
    public function setPointsOfCharacteristics($pointsOfCharacteristics)
    {
        $this->pointsOfCharacteristics = $pointsOfCharacteristics;

        return $this;
    }

    /**
     * Get pointsOfCharacteristics
     *
     * @return integer
     */
    public function getPointsOfCharacteristics()
    {
        return $this->pointsOfCharacteristics;
    }

    /**
     * Set kamas
     *
     * @param integer $kamas
     *
     * @return Player
     */
    public function setKamas($kamas)
    {
        $this->kamas = $kamas;

        return $this;
    }

    /**
     * Get kamas
     *
     * @return integer
     */
    public function getKamas()
    {
        return $this->kamas;
    }

    /**
     * Set baseVitality
     *
     * @param integer $baseVitality
     *
     * @return Player
     */
    public function setBaseVitality($baseVitality)
    {
        $this->baseVitality = $baseVitality;

        return $this;
    }

    /**
     * Get baseVitality
     *
     * @return integer
     */
    public function getBaseVitality()
    {
        return $this->baseVitality;
    }

    /**
     * Set vitality
     *
     * @param integer $vitality
     *
     * @return Player
     */
    public function setVitality($vitality)
    {
        $this->vitality = $vitality;

        return $this;
    }

    /**
     * Get vitality
     *
     * @return integer
     */
    public function getVitality()
    {
        return $this->vitality;
    }

    /**
     * Set baseWisdom
     *
     * @param integer $baseWisdom
     *
     * @return Player
     */
    public function setBaseWisdom($baseWisdom)
    {
        $this->baseWisdom = $baseWisdom;

        return $this;
    }

    /**
     * Get baseWisdom
     *
     * @return integer
     */
    public function getBaseWisdom()
    {
        return $this->baseWisdom;
    }

    /**
     * Set wisdom
     *
     * @param integer $wisdom
     *
     * @return Player
     */
    public function setWisdom($wisdom)
    {
        $this->wisdom = $wisdom;

        return $this;
    }

    /**
     * Get wisdom
     *
     * @return integer
     */
    public function getWisdom()
    {
        return $this->wisdom;
    }

    /**
     * Set baseStrength
     *
     * @param integer $baseStrength
     *
     * @return Player
     */
    public function setBaseStrength($baseStrength)
    {
        $this->baseStrength = $baseStrength;

        return $this;
    }

    /**
     * Get baseStrength
     *
     * @return integer
     */
    public function getBaseStrength()
    {
        return $this->baseStrength;
    }

    /**
     * Set strength
     *
     * @param integer $strength
     *
     * @return Player
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;

        return $this;
    }

    /**
     * Get strength
     *
     * @return integer
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * Set baseIntelligence
     *
     * @param integer $baseIntelligence
     *
     * @return Player
     */
    public function setBaseIntelligence($baseIntelligence)
    {
        $this->baseIntelligence = $baseIntelligence;

        return $this;
    }

    /**
     * Get baseIntelligence
     *
     * @return integer
     */
    public function getBaseIntelligence()
    {
        return $this->baseIntelligence;
    }

    /**
     * Set intelligence
     *
     * @param integer $intelligence
     *
     * @return Player
     */
    public function setIntelligence($intelligence)
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    /**
     * Get intelligence
     *
     * @return integer
     */
    public function getIntelligence()
    {
        return $this->intelligence;
    }

    /**
     * Set baseChance
     *
     * @param integer $baseChance
     *
     * @return Player
     */
    public function setBaseChance($baseChance)
    {
        $this->baseChance = $baseChance;

        return $this;
    }

    /**
     * Get baseChance
     *
     * @return integer
     */
    public function getBaseChance()
    {
        return $this->baseChance;
    }

    /**
     * Set chance
     *
     * @param integer $chance
     *
     * @return Player
     */
    public function setChance($chance)
    {
        $this->chance = $chance;

        return $this;
    }

    /**
     * Get chance
     *
     * @return integer
     */
    public function getChance()
    {
        return $this->chance;
    }

    /**
     * Set baseAgility
     *
     * @param integer $baseAgility
     *
     * @return Player
     */
    public function setBaseAgility($baseAgility)
    {
        $this->baseAgility = $baseAgility;

        return $this;
    }

    /**
     * Get baseAgility
     *
     * @return integer
     */
    public function getBaseAgility()
    {
        return $this->baseAgility;
    }

    /**
     * Set agility
     *
     * @param integer $agility
     *
     * @return Player
     */
    public function setAgility($agility)
    {
        $this->agility = $agility;

        return $this;
    }

    /**
     * Get agility
     *
     * @return integer
     */
    public function getAgility()
    {
        return $this->agility;
    }

    /**
     * Set lifePoints
     *
     * @param integer $lifePoints
     *
     * @return Player
     */
    public function setLifePoints($lifePoints)
    {
        $this->lifePoints = $lifePoints;

        return $this;
    }

    /**
     * Get lifePoints
     *
     * @return integer
     */
    public function getLifePoints()
    {
        return $this->lifePoints;
    }

    /**
     * Set maximumLifePoints
     *
     * @param integer $maximumLifePoints
     *
     * @return Player
     */
    public function setMaximumLifePoints($maximumLifePoints)
    {
        $this->maximumLifePoints = $maximumLifePoints;

        return $this;
    }

    /**
     * Get maximumLifePoints
     *
     * @return integer
     */
    public function getMaximumLifePoints()
    {
        return $this->maximumLifePoints;
    }

    /**
     * Set faction
     *
     * @param integer $faction
     *
     * @return Player
     */
    public function setFaction($faction)
    {
        $this->faction = $faction;

        return $this;
    }

    /**
     * Get faction
     *
     * @return integer
     */
    public function getFaction()
    {
        return $this->faction;
    }

    /**
     * Set factionHonorPoints
     *
     * @param integer $factionHonorPoints
     *
     * @return Player
     */
    public function setFactionHonorPoints($factionHonorPoints)
    {
        $this->factionHonorPoints = $factionHonorPoints;

        return $this;
    }

    /**
     * Get factionHonorPoints
     *
     * @return integer
     */
    public function getFactionHonorPoints()
    {
        return $this->factionHonorPoints;
    }

    /**
     * Set guildId
     *
     * @param integer $guildId
     *
     * @return Player
     */
    public function setGuildId($guildId)
    {
        $this->guildId = $guildId;

        return $this;
    }

    /**
     * Get guildId
     *
     * @return integer
     */
    public function getGuildId()
    {
        return $this->guildId;
    }

    /**
     * Set account
     *
     * @param \Hetwan\Entity\Account $account
     *
     * @return Player
     */
    public function setAccount(Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \Hetwan\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set equiped items
     *
     * @param array @equipedItems
     *
     * @return Player
     */
    public function setEquipedItems($equipedItems)
    {
        $this->equipedItems = $equipedItems;

        return $this;
    }

    /**
     * Get equiped items
     *
     * @return \array
     */
    public function getEquipedItems()
    {
        return $this->equipedItems;
    }

    /**
     * Set inventory
     *
     * @param array @inventory
     *
     * @return Player
     */
    public function setInventory($inventory)
    {
        $this->inventory = $inventory;

        return $this;
    }

    /**
     * Get inventory
     *
     * @return array
     */
    public function getInventory()
    {
        return $this->inventory;
    }
}