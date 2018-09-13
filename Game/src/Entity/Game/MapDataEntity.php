<?php

namespace Hetwan\Entity\Game;


/**
 * @Entity
 * @Table(name="maps_data", indexes={@Index(name="id", columns={"id"})})
 */
class MapDataEntity
{
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     */
    private $id;

    /**
     * @Column(type="text", nullable=true)
     */
    private $date;

    /**
     * @Column(type="integer", nullable=true)
     */
    private $width;

    /**
     * @Column(type="integer", nullable=true)
     */
    private $height;

    /**
     * @Column(type="text", nullable=true)
     */
    private $mapData;

    /**
     * @Column(type="text", nullable=true)
     */
    private $decryptedMapData;

    /**
     * @Column(type="text", nullable=true)
     */
    private $key;

    /**
     * @Column(type="integer", nullable=true)
     */
    private $x;

    /**
     * @Column(type="integer", nullable=true)
     */
    private $y;

    /**
     * @Column(type="integer", nullable=true)
     */
    private $subAreaId;

    /**
     * @var array
     */
    private $players = [];

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return MapDataEntity
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
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
     * Set date.
     *
     * @param string|null $date
     *
     * @return MapDataEntity
     */
    public function setDate($date = null)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date.
     *
     * @return string|null
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set width.
     *
     * @param int|null $width
     *
     * @return MapDataEntity
     */
    public function setWidth($width = null)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width.
     *
     * @return int|null
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height.
     *
     * @param int|null $height
     *
     * @return MapDataEntity
     */
    public function setHeight($height = null)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height.
     *
     * @return int|null
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set mapData.
     *
     * @param string|null $mapData
     *
     * @return MapDataEntity
     */
    public function setMapData($mapData = null)
    {
        $this->mapData = $mapData;

        return $this;
    }

    /**
     * Get mapData.
     *
     * @return string|null
     */
    public function getMapData()
    {
        return $this->mapData;
    }

    /**
     * Set decryptedMapData.
     *
     * @param string|null $decryptedMapData
     *
     * @return MapDataEntity
     */
    public function setDecryptedMapData($decryptedMapData = null)
    {
        $this->decryptedMapData = $decryptedMapData;

        return $this;
    }

    /**
     * Get decryptedMapData.
     *
     * @return string|null
     */
    public function getDecryptedMapData()
    {
        return $this->decryptedMapData;
    }

    /**
     * Set key.
     *
     * @param string|null $key
     *
     * @return MapDataEntity
     */
    public function setKey($key = null)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key.
     *
     * @return string|null
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set x.
     *
     * @param int|null $x
     *
     * @return MapDataEntity
     */
    public function setX($x = null)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get x.
     *
     * @return int|null
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set y.
     *
     * @param int|null $y
     *
     * @return MapDataEntity
     */
    public function setY($y = null)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Get y.
     *
     * @return int|null
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set subAreaId.
     *
     * @param int|null $subAreaId
     *
     * @return MapDataEntity
     */
    public function setSubAreaId($subAreaId = null)
    {
        $this->subAreaId = $subAreaId;

        return $this;
    }

    /**
     * Get subAreaId.
     *
     * @return int|null
     */
    public function getSubAreaId()
    {
        return $this->subAreaId;
    }

    /* POST GENERATION METHODS */

    /**
     * Add player
     *
     * @param \Hetwan\Entity\Game\PlayerEntity $player
     * @return \Hetwan\Entity\Game\MapDataEntity
     */
    public function addPlayer(\Hetwan\Entity\Game\PlayerEntity $player) : \Hetwan\Entity\Game\MapDataEntity
    {
        $this->players[$player->getId()] = $player;

        return $this;
    }

    /**
     * Remove player
     *
     * @param \Hetwan\Entity\Game\PlayerEntity $player
     * @return \Hetwan\Entity\Game\MapDataEntity
     */
    public function removePlayer(\Hetwan\Entity\Game\PlayerEntity $player) : \Hetwan\Entity\Game\MapDataEntity
    {
        unset($this->players[$player->getId()]);

        return $this;
    }

    /**
     * Get players
     *
     * @return array
     */
    public function getPlayers() : array
    {
        return $this->players;
    }
}
