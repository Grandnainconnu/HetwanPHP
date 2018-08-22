<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 19:01:40
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-30 19:21:46
 */

namespace Hetwan\Entity\Login;


trait PlayerTrait
{
    /**
     * @var array
     */
    protected $equipedItems = [];

    /**
     * @var array
     */
    protected $inventoryItems = [];

    /**
     * @var char
     */
    protected $orientation = 0;

    /**
     * @var int
     */
    protected $action;

    /**
     * @var \PlayerCharacteristic
     */
    protected $characteristics;

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
     * Get equiped items bonus
     *
     * @return \array
     */
    public function getEquipedItemsBonus()
    {
        $equipedItemsBonus = [];

        foreach ($this->equipedItems as $item)
            foreach (\Hetwan\Helper\ItemEffectHelper::getEffectsFromString($item->getEffects()) as $effectId => $effect)
                if (isset($equipedItemsBonus[$effectId]))
                    $equipedItemsBonus[$effectId] += $effect;
                else
                    $equipedItemsBonus[$effectId] = $effect;

        return $equipedItemsBonus;
    }

    /**
     * Set inventory
     *
     * @param array @inventory
     *
     * @return Player
     */
    public function setInventoryItems($inventory)
    {
        $this->inventoryItems = $inventory;

        return $this;
    }

    /**
     * Get inventory
     *
     * @return array
     */
    public function getInventoryItems()
    {
        return $this->inventoryItems;
    }

    /**
     * Set player statistics
     *
     * @return Player
     */
    public function setCharacteristics()
    {
        $this->characteristics = \Hetwan\Helper\Characteristic\CharacteristicHelper::makePlayerCharacteristics($this);

        $this->characteristics->updateSecondaryCharacteristics($this);

        return $this;
    }

    /**
     * Get player statistics
     *
     * @return string
     */
    public function getCharacteristics($useCache = true)
    {
        if (!$useCache || !$this->characteristics)
            $this->setCharacteristics();

        return $this->characteristics;
    }

    /**
     * Set orientation
     *
     * @param string @orientation
     *
     * @return Player
     */
    public function setOrientation($orientation)
    {
        $this->orientation = $orientation;

        return $this;
    }

    /**
     * Get orientation
     *
     * @return string
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * Set action
     *
     * @param int @action
     *
     * @return Player
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return int
     */
    public function getAction()
    {
        return $this->action;
    }

    /** 
     * On player loaded
     *
     * @PostLoad 
    */
    public function postLoad(\Doctrine\ORM\Event\LifecycleEventArgs $event)
    {
        $this->setEquipedItems(\Hetwan\Helper\ItemHelper::getPlayerEquipedItems($this->getId()));
        $this->setInventoryItems(\Hetwan\Helper\ItemHelper::getPlayerInventoryItems($this->getId()));
    }

    public function refreshInventoryItems()
    {    
        $this->setInventoryItems(\Hetwan\Helper\ItemHelper::getPlayerInventoryItems($this->getId()));
    }

    public function refreshEquipedItems()
    {
        $this->setEquipedItems(\Hetwan\Helper\ItemHelper::getPlayerEquipedItems($this->getId()));
    }

    public function save()
    {
        // Update player characteristics on save
        $this->setVitality($this->getCharacteristics()->getCharacteristic('vitality')->getBase());
        $this->setWisdom($this->getCharacteristics()->getCharacteristic('wisdom')->getBase());
        $this->setStrength($this->getCharacteristics()->getCharacteristic('strength')->getBase());
        $this->setIntelligence($this->getCharacteristics()->getCharacteristic('intelligence')->getBase());
        $this->setChance($this->getCharacteristics()->getCharacteristic('chance')->getBase());
        $this->setAgility($this->getCharacteristics()->getCharacteristic('agility')->getBase());

        parent::save();
    }
}

/**
 * @Entity(repositoryClass="Hetwan\Repository\PlayerRepository")
 * @Table(name="players")
 * @HasLifecycleCallbacks
 **/
class Player extends AbstractLoginEntity
{
    use PlayerTrait;

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
     * @Column(type="integer")
     * @var int
     */
    protected $actionPoints;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $movementPoints;

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
     * @Column(type="integer", options={"default": "0"})
     * @var int
     */
    protected $factionDishonorPoints;

    /**
     * @Column(type="text", nullable=true)
     * @var string
     */
    protected $channels;

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
     * Set actionPoints
     *
     * @param integer $actionPoints
     *
     * @return Player
     */
    public function setActionPoints($actionPoints)
    {
        $this->actionPoints = $actionPoints;

        return $this;
    }

    /**
     * Get actionPoints
     *
     * @return integer
     */
    public function getActionPoints()
    {
        return $this->actionPoints;
    }

    /**
     * Set movementPoints
     *
     * @param integer $movementPoints
     *
     * @return Player
     */
    public function setMovementPoints($movementPoints)
    {
        $this->movementPoints = $movementPoints;

        return $this;
    }

    /**
     * Get movementPoints
     *
     * @return integer
     */
    public function getMovementPoints()
    {
        return $this->movementPoints;
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
     * Get total life points
     *
     * @return integer
     */
    public function getTotalLifePoints()
    {
        return $this->lifePoints +  $this->getCharacteristics()->getCharacteristic('vitality')->getTotal();
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
     * Get total maximumLifePoints
     *
     * @return integer
     */
    public function getTotalMaximumLifePoints()
    {
        return $this->maximumLifePoints + $this->getCharacteristics()->getCharacteristic('vitality')->getTotal();
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
     * Set factionDishonorPoints
     *
     * @param integer $factionDishonorPoints
     *
     * @return Player
     */
    public function setFactionDishonorPoints($factionDishonorPoints)
    {
        $this->factionDishonorPoints = $factionDishonorPoints;

        return $this;
    }

    /**
     * Get factionDishonorPoints
     *
     * @return integer
     */
    public function getFactionDishonorPoints()
    {
        return $this->factionDishonorPoints;
    }

    /**
     * Set channels
     *
     * @param \array $channels
     *
     * @return Player
     */
    public function setChannels($channels)
    {
        $this->channels = implode(';', $channels);

        return $this;
    }

    /**
     * Get channels
     *
     * @return \array
     */
    public function getChannels()
    {
        return explode(';', $this->channels);
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
     * @param \Hetwan\Entity\Login\Account $account
     *
     * @return Player
     */
    public function setAccount(\Hetwan\Entity\Login\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \Hetwan\Entity\Login\Account
     */
    public function getAccount()
    {
        return $this->account;
    }
}