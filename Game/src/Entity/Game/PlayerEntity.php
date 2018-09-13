<?php

namespace Hetwan\Entity\Game;

use Hetwan\Helper\Characteristic\CharacteristicHelper;


/**
 * @Entity(repositoryClass="Hetwan\Repository\PlayerRepository")
 * @Table(name="players")
 * @HasLifecycleCallbacks
 **/
class PlayerEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string")
     */
    private $name;

    /**
     * @Column(type="integer", nullable=true)
     */
    private $titleId;

    /**
     * @Column(type="integer")
     */
    private $breed;

    /**
     * @Column(type="integer")
     */
    private $gender;

    /**
     * @Column(type="string")
     */
    protected $colors;

    /**
     * @Column(type="integer")
     */
    private $level;

    /**
     * @Column(type="integer")
     */
    private $skinId;

    /**
     * @Column(type="boolean", options={"default":"0"})
     */
    private $isMerchant = false;

    /**
     * @Column(type="boolean", options={"default":"0"})
     */
    private $isDead = false;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $deathCount = 0;

    /**
     * @Column(type="integer", nullable=true)
     */
    private $orientation;

    /**
     * @Column(type="integer", nullable=true)
     */
    private $cellId;

    /**
     * @Column(type="integer", nullable=true)
     */
    private $mapId;

    /**
     * @Column(type="integer", nullable=true)
     */
    private $savedCellId;

    /**
     * @Column(type="integer", nullable=true)
     */
    private $savedMapId;

    /**
     * @Column(type="integer", nullable=true)
     */
    private $savedOrientation;

    /**
     * @Column(type="integer", options={"default":"10000"})
     */
    private $energy = 10000;

    /**
     * @Column(type="integer", options={"default":"6"})
     */
    private $actionPoints = 6;

    /**
     * @Column(type="integer", options={"default":"3"})
     */
    private $movementPoints = 3;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $experience = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $spellPoints = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $pointsOfCharacteristics = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $kamas = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $baseVitality = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $vitality = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $baseWisdom = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $wisdom = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $baseStrength = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $strength = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $baseIntelligence = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $intelligence = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $baseChance = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $chance = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $baseAgility = 0;

    /**
     * @Column(type="integer", options={"default":"0"})
     */
    private $agility = 0;

    /**
     * @Column(type="integer", nullable=true)
     */
    protected $lifePoints;

    /**
     * @Column(type="integer", nullable=true)
     */
    protected $maximumLifePoints;

    /**
     * @OneToMany(targetEntity="ItemEntity", mappedBy="player", cascade={"persist"})
     */
    private $items;

    /**
     * @OneToMany(targetEntity="ItemEntity", mappedBy="storePlayer", cascade={"persist"})
     */
    private $storeItems;

    /**
     * @Column(type="integer", options={"default": "-1"})
     */
    private $faction = -1;

    /**
     * @Column(type="integer", options={"default": "0"})
     */
    private $factionHonorPoints = 0;

    /**
     * @Column(type="integer", options={"default": "0"})
     */
    private $factionDishonorPoints = 0;

    /**
     * @Column(type="boolean", options={"default": "0"})
     */
    private $factionFightEnabled = 0;

    /**
     * @OneToMany(targetEntity="JobEntity", mappedBy="player")
     */
    private $jobs;

    /**
     * @Column(type="array", nullable=true)
     */
    private $channels;

    /**
     * @Column(type="array", nullable=true)
     */
    private $zaaps;

    /**
     * @ManyToOne(targetEntity="GuildEntity", inversedBy="players")
     * @JoinColumn(name="guildId", referencedColumnName="id")
     */
    private $guild;

    /**
     * @Column(type="integer")
     */
    private $accountId;

    /**
     * @var \Hetwan\Helper\Characteristic\Player\Characteristics
     */
    private $characteristics;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
        $this->storeItems = new \Doctrine\Common\Collections\ArrayCollection();
        $this->jobs = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return PlayerEntity
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
     * Set titleId.
     *
     * @param int|null $titleId
     *
     * @return PlayerEntity
     */
    public function setTitleId($titleId = null)
    {
        $this->titleId = $titleId;

        return $this;
    }

    /**
     * Get titleId.
     *
     * @return int|null
     */
    public function getTitleId()
    {
        return $this->titleId;
    }

    /**
     * Set breed.
     *
     * @param int $breed
     *
     * @return PlayerEntity
     */
    public function setBreed($breed)
    {
        $this->breed = $breed;

        return $this;
    }

    /**
     * Get breed.
     *
     * @return int
     */
    public function getBreed()
    {
        return $this->breed;
    }

    /**
     * Set gender.
     *
     * @param int $gender
     *
     * @return PlayerEntity
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender.
     *
     * @return int
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set colors.
     *
     * @param string $colors
     *
     * @return PlayerEntity
     */
    public function setColors($colors)
    {
        $this->colors = $colors;

        return $this;
    }

    /**
     * Get colors.
     *
     * @return string
     */
    public function getColors()
    {
        return $this->colors;
    }

    /**
     * Set level.
     *
     * @param int $level
     *
     * @return PlayerEntity
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
     * Set skinId.
     *
     * @param int $skinId
     *
     * @return PlayerEntity
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
     * Set isMerchant.
     *
     * @param bool $isMerchant
     *
     * @return PlayerEntity
     */
    public function setIsMerchant($isMerchant)
    {
        $this->isMerchant = $isMerchant;

        return $this;
    }

    /**
     * Get isMerchant.
     *
     * @return bool
     */
    public function getIsMerchant()
    {
        return $this->isMerchant;
    }

    /**
     * Set isDead.
     *
     * @param bool $isDead
     *
     * @return PlayerEntity
     */
    public function setIsDead($isDead)
    {
        $this->isDead = $isDead;

        return $this;
    }

    /**
     * Get isDead.
     *
     * @return bool
     */
    public function getIsDead()
    {
        return $this->isDead;
    }

    /**
     * Set deathCount.
     *
     * @param int $deathCount
     *
     * @return PlayerEntity
     */
    public function setDeathCount($deathCount)
    {
        $this->deathCount = $deathCount;

        return $this;
    }

    /**
     * Get deathCount.
     *
     * @return int
     */
    public function getDeathCount()
    {
        return $this->deathCount;
    }

    /**
     * Set orientation.
     *
     * @param int|null $orientation
     *
     * @return PlayerEntity
     */
    public function setOrientation($orientation = null)
    {
        $this->orientation = $orientation;

        return $this;
    }

    /**
     * Get orientation.
     *
     * @return int|null
     */
    public function getOrientation()
    {
        return $this->orientation;
    }

    /**
     * Set cellId.
     *
     * @param int|null $cellId
     *
     * @return PlayerEntity
     */
    public function setCellId($cellId = null)
    {
        $this->cellId = $cellId;

        return $this;
    }

    /**
     * Get cellId.
     *
     * @return int|null
     */
    public function getCellId()
    {
        return $this->cellId;
    }

    /**
     * Set mapId.
     *
     * @param int|null $mapId
     *
     * @return PlayerEntity
     */
    public function setMapId($mapId = null)
    {
        $this->mapId = $mapId;

        return $this;
    }

    /**
     * Get mapId.
     *
     * @return int|null
     */
    public function getMapId()
    {
        return $this->mapId;
    }

    /**
     * Set savedCellId.
     *
     * @param int|null $savedCellId
     *
     * @return PlayerEntity
     */
    public function setSavedCellId($savedCellId = null)
    {
        $this->savedCellId = $savedCellId;

        return $this;
    }

    /**
     * Get savedCellId.
     *
     * @return int|null
     */
    public function getSavedCellId()
    {
        return $this->savedCellId;
    }

    /**
     * Set savedMapId.
     *
     * @param int|null $savedMapId
     *
     * @return PlayerEntity
     */
    public function setSavedMapId($savedMapId = null)
    {
        $this->savedMapId = $savedMapId;

        return $this;
    }

    /**
     * Get savedMapId.
     *
     * @return int|null
     */
    public function getSavedMapId()
    {
        return $this->savedMapId;
    }

    /**
     * Set savedOrientation.
     *
     * @param int|null $savedOrientation
     *
     * @return PlayerEntity
     */
    public function setSavedOrientation($savedOrientation = null)
    {
        $this->savedOrientation = $savedOrientation;

        return $this;
    }

    /**
     * Get savedOrientation.
     *
     * @return int|null
     */
    public function getSavedOrientation()
    {
        return $this->savedOrientation;
    }

    /**
     * Set energy.
     *
     * @param int $energy
     *
     * @return PlayerEntity
     */
    public function setEnergy($energy)
    {
        $this->energy = $energy;

        return $this;
    }

    /**
     * Get energy.
     *
     * @return int
     */
    public function getEnergy()
    {
        return $this->energy;
    }

    /**
     * Set actionPoints.
     *
     * @param int $actionPoints
     *
     * @return PlayerEntity
     */
    public function setActionPoints($actionPoints)
    {
        $this->actionPoints = $actionPoints;

        return $this;
    }

    /**
     * Get actionPoints.
     *
     * @return int
     */
    public function getActionPoints()
    {
        return $this->actionPoints;
    }

    /**
     * Set movementPoints.
     *
     * @param int $movementPoints
     *
     * @return PlayerEntity
     */
    public function setMovementPoints($movementPoints)
    {
        $this->movementPoints = $movementPoints;

        return $this;
    }

    /**
     * Get movementPoints.
     *
     * @return int
     */
    public function getMovementPoints()
    {
        return $this->movementPoints;
    }

    /**
     * Set experience.
     *
     * @param int $experience
     *
     * @return PlayerEntity
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;

        return $this;
    }

    /**
     * Get experience.
     *
     * @return int
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set spellPoints.
     *
     * @param int $spellPoints
     *
     * @return PlayerEntity
     */
    public function setSpellPoints($spellPoints)
    {
        $this->spellPoints = $spellPoints;

        return $this;
    }

    /**
     * Get spellPoints.
     *
     * @return int
     */
    public function getSpellPoints()
    {
        return $this->spellPoints;
    }

    /**
     * Set pointsOfCharacteristics.
     *
     * @param int $pointsOfCharacteristics
     *
     * @return PlayerEntity
     */
    public function setPointsOfCharacteristics($pointsOfCharacteristics)
    {
        $this->pointsOfCharacteristics = $pointsOfCharacteristics;

        return $this;
    }

    /**
     * Get pointsOfCharacteristics.
     *
     * @return int
     */
    public function getPointsOfCharacteristics()
    {
        return $this->pointsOfCharacteristics;
    }

    /**
     * Set kamas.
     *
     * @param int $kamas
     *
     * @return PlayerEntity
     */
    public function setKamas($kamas)
    {
        $this->kamas = $kamas;

        return $this;
    }

    /**
     * Get kamas.
     *
     * @return int
     */
    public function getKamas()
    {
        return $this->kamas;
    }

    /**
     * Set baseVitality.
     *
     * @param int $baseVitality
     *
     * @return PlayerEntity
     */
    public function setBaseVitality($baseVitality)
    {
        $this->baseVitality = $baseVitality;

        return $this;
    }

    /**
     * Get baseVitality.
     *
     * @return int
     */
    public function getBaseVitality()
    {
        return $this->baseVitality;
    }

    /**
     * Set vitality.
     *
     * @param int $vitality
     *
     * @return PlayerEntity
     */
    public function setVitality($vitality)
    {
        $this->vitality = $vitality;

        return $this;
    }

    /**
     * Get vitality.
     *
     * @return int
     */
    public function getVitality()
    {
        return $this->vitality;
    }

    /**
     * Set baseWisdom.
     *
     * @param int $baseWisdom
     *
     * @return PlayerEntity
     */
    public function setBaseWisdom($baseWisdom)
    {
        $this->baseWisdom = $baseWisdom;

        return $this;
    }

    /**
     * Get baseWisdom.
     *
     * @return int
     */
    public function getBaseWisdom()
    {
        return $this->baseWisdom;
    }

    /**
     * Set wisdom.
     *
     * @param int $wisdom
     *
     * @return PlayerEntity
     */
    public function setWisdom($wisdom)
    {
        $this->wisdom = $wisdom;

        return $this;
    }

    /**
     * Get wisdom.
     *
     * @return int
     */
    public function getWisdom()
    {
        return $this->wisdom;
    }

    /**
     * Set baseStrength.
     *
     * @param int $baseStrength
     *
     * @return PlayerEntity
     */
    public function setBaseStrength($baseStrength)
    {
        $this->baseStrength = $baseStrength;

        return $this;
    }

    /**
     * Get baseStrength.
     *
     * @return int
     */
    public function getBaseStrength()
    {
        return $this->baseStrength;
    }

    /**
     * Set strength.
     *
     * @param int $strength
     *
     * @return PlayerEntity
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;

        return $this;
    }

    /**
     * Get strength.
     *
     * @return int
     */
    public function getStrength()
    {
        return $this->strength;
    }

    /**
     * Set baseIntelligence.
     *
     * @param int $baseIntelligence
     *
     * @return PlayerEntity
     */
    public function setBaseIntelligence($baseIntelligence)
    {
        $this->baseIntelligence = $baseIntelligence;

        return $this;
    }

    /**
     * Get baseIntelligence.
     *
     * @return int
     */
    public function getBaseIntelligence()
    {
        return $this->baseIntelligence;
    }

    /**
     * Set intelligence.
     *
     * @param int $intelligence
     *
     * @return PlayerEntity
     */
    public function setIntelligence($intelligence)
    {
        $this->intelligence = $intelligence;

        return $this;
    }

    /**
     * Get intelligence.
     *
     * @return int
     */
    public function getIntelligence()
    {
        return $this->intelligence;
    }

    /**
     * Set baseChance.
     *
     * @param int $baseChance
     *
     * @return PlayerEntity
     */
    public function setBaseChance($baseChance)
    {
        $this->baseChance = $baseChance;

        return $this;
    }

    /**
     * Get baseChance.
     *
     * @return int
     */
    public function getBaseChance()
    {
        return $this->baseChance;
    }

    /**
     * Set chance.
     *
     * @param int $chance
     *
     * @return PlayerEntity
     */
    public function setChance($chance)
    {
        $this->chance = $chance;

        return $this;
    }

    /**
     * Get chance.
     *
     * @return int
     */
    public function getChance()
    {
        return $this->chance;
    }

    /**
     * Set baseAgility.
     *
     * @param int $baseAgility
     *
     * @return PlayerEntity
     */
    public function setBaseAgility($baseAgility)
    {
        $this->baseAgility = $baseAgility;

        return $this;
    }

    /**
     * Get baseAgility.
     *
     * @return int
     */
    public function getBaseAgility()
    {
        return $this->baseAgility;
    }

    /**
     * Set agility.
     *
     * @param int $agility
     *
     * @return PlayerEntity
     */
    public function setAgility($agility)
    {
        $this->agility = $agility;

        return $this;
    }

    /**
     * Get agility.
     *
     * @return int
     */
    public function getAgility()
    {
        return $this->agility;
    }

    /**
     * Set lifePoints.
     *
     * @param int|null $lifePoints
     *
     * @return PlayerEntity
     */
    public function setLifePoints($lifePoints = null)
    {
        $this->lifePoints = $lifePoints;

        return $this;
    }

    /**
     * Get lifePoints.
     *
     * @return int|null
     */
    public function getLifePoints()
    {
        return $this->lifePoints;
    }

    /**
     * Set maximumLifePoints.
     *
     * @param int|null $maximumLifePoints
     *
     * @return PlayerEntity
     */
    public function setMaximumLifePoints($maximumLifePoints = null)
    {
        $this->maximumLifePoints = $maximumLifePoints;

        return $this;
    }

    /**
     * Get maximumLifePoints.
     *
     * @return int|null
     */
    public function getMaximumLifePoints()
    {
        return $this->maximumLifePoints;
    }

    /**
     * Set faction.
     *
     * @param int $faction
     *
     * @return PlayerEntity
     */
    public function setFaction($faction)
    {
        $this->faction = $faction;

        return $this;
    }

    /**
     * Get faction.
     *
     * @return int
     */
    public function getFaction()
    {
        return $this->faction;
    }

    /**
     * Set factionHonorPoints.
     *
     * @param int $factionHonorPoints
     *
     * @return PlayerEntity
     */
    public function setFactionHonorPoints($factionHonorPoints)
    {
        $this->factionHonorPoints = $factionHonorPoints;

        return $this;
    }

    /**
     * Get factionHonorPoints.
     *
     * @return int
     */
    public function getFactionHonorPoints()
    {
        return $this->factionHonorPoints;
    }

    /**
     * Set factionDishonorPoints.
     *
     * @param int $factionDishonorPoints
     *
     * @return PlayerEntity
     */
    public function setFactionDishonorPoints($factionDishonorPoints)
    {
        $this->factionDishonorPoints = $factionDishonorPoints;

        return $this;
    }

    /**
     * Get factionDishonorPoints.
     *
     * @return int
     */
    public function getFactionDishonorPoints()
    {
        return $this->factionDishonorPoints;
    }

    /**
     * Set factionFightEnabled.
     *
     * @param bool $factionFightEnabled
     *
     * @return PlayerEntity
     */
    public function setFactionFightEnabled($factionFightEnabled)
    {
        $this->factionFightEnabled = $factionFightEnabled;

        return $this;
    }

    /**
     * Get factionFightEnabled.
     *
     * @return bool
     */
    public function getFactionFightEnabled()
    {
        return $this->factionFightEnabled;
    }

    /**
     * Set channels.
     *
     * @param array|null $channels
     *
     * @return PlayerEntity
     */
    public function setChannels($channels = null)
    {
        $this->channels = $channels;

        return $this;
    }

    /**
     * Get channels.
     *
     * @return array|null
     */
    public function getChannels()
    {
        return $this->channels;
    }

    /**
     * Set zaaps.
     *
     * @param array|null $zaaps
     *
     * @return PlayerEntity
     */
    public function setZaaps($zaaps = null)
    {
        $this->zaaps = $zaaps;

        return $this;
    }

    /**
     * Get zaaps.
     *
     * @return array|null
     */
    public function getZaaps()
    {
        return $this->zaaps;
    }

    /**
     * Set accountId.
     *
     * @param int $accountId
     *
     * @return PlayerEntity
     */
    public function setAccountId($accountId)
    {
        $this->accountId = $accountId;

        return $this;
    }

    /**
     * Get accountId.
     *
     * @return int
     */
    public function getAccountId()
    {
        return $this->accountId;
    }

    /**
     * Add item.
     *
     * @param \Hetwan\Entity\Game\ItemEntity $item
     *
     * @return PlayerEntity
     */
    public function addItem(\Hetwan\Entity\Game\ItemEntity $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item.
     *
     * @param \Hetwan\Entity\Game\ItemEntity $item
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeItem(\Hetwan\Entity\Game\ItemEntity $item)
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

    /**
     * Add storeItem.
     *
     * @param \Hetwan\Entity\Game\ItemEntity $storeItem
     *
     * @return PlayerEntity
     */
    public function addStoreItem(\Hetwan\Entity\Game\ItemEntity $storeItem)
    {
        $this->storeItems[] = $storeItem;

        return $this;
    }

    /**
     * Remove storeItem.
     *
     * @param \Hetwan\Entity\Game\ItemEntity $storeItem
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeStoreItem(\Hetwan\Entity\Game\ItemEntity $storeItem)
    {
        return $this->storeItems->removeElement($storeItem);
    }

    /**
     * Get storeItems.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStoreItems()
    {
        return $this->storeItems;
    }

    /**
     * Add job.
     *
     * @param \Hetwan\Entity\Game\JobEntity $job
     *
     * @return PlayerEntity
     */
    public function addJob(\Hetwan\Entity\Game\JobEntity $job)
    {
        $this->jobs[] = $job;

        return $this;
    }

    /**
     * Remove job.
     *
     * @param \Hetwan\Entity\Game\JobEntity $job
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeJob(\Hetwan\Entity\Game\JobEntity $job)
    {
        return $this->jobs->removeElement($job);
    }

    /**
     * Get jobs.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getJobs()
    {
        return $this->jobs;
    }

    /**
     * Set guild.
     *
     * @param \Hetwan\Entity\Game\GuildEntity|null $guild
     *
     * @return PlayerEntity
     */
    public function setGuild(\Hetwan\Entity\Game\GuildEntity $guild = null)
    {
        $this->guild = $guild;

        return $this;
    }

    /**
     * Get guild.
     *
     * @return \Hetwan\Entity\Game\GuildEntity|null
     */
    public function getGuild()
    {
        return $this->guild;
    }

    /* POST GENERATION METHODS */

    /**
     * @PreUpdate
     */
    public function update() : void
    {
        $this->setVitality($this->getCharacteristics()->getCharacteristic('vitality')->getBase());
        $this->setWisdom($this->getCharacteristics()->getCharacteristic('wisdom')->getBase());
        $this->setStrength($this->getCharacteristics()->getCharacteristic('strength')->getBase());
        $this->setIntelligence($this->getCharacteristics()->getCharacteristic('intelligence')->getBase());
        $this->setChance($this->getCharacteristics()->getCharacteristic('chance')->getBase());
        $this->setAgility($this->getCharacteristics()->getCharacteristic('agility')->getBase());
    }

    /**
     * Set player characteristics
     *
     * @return \Hetwan\Entity\Game\PlayerEntity
     */
    public function generateCharacteristics() : \Hetwan\Entity\Game\PlayerEntity
    {
        $this->characteristics = CharacteristicHelper::generatePlayerCharacteristics($this);

        return $this;
    }

    /**
     * Get player characteristics
     *
     * @return \Hetwan\Helper\Characteristic\Player\Characteristics
     */
    public function getCharacteristics(bool $useCache = true) : \Hetwan\Helper\Characteristic\Player\Characteristics
    {
        if (!$useCache or $this->characteristics === null) {
            $this->generateCharacteristics();
        }

        return $this->characteristics;
    }

    /**
     * Get total life points
     *
     * @return int
     */
    public function getTotalLifePoints() : int
    {
        return $this->lifePoints +  $this->characteristics->getCharacteristic('vitality')->getTotal();
    }

    /**
     * Get total maximumLifePoints
     *
     * @return int
     */
    public function getTotalMaximumLifePoints() : int
    {
        return $this->maximumLifePoints + $this->characteristics->getCharacteristic('vitality')->getTotal();
    }
}