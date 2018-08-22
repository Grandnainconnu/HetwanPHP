<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-23 20:39:01
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-29 22:13:00
 */

namespace Hetwan\Entity\Game;


trait MapDataTrait
{
    /**
     * @var array
     */
    private $players = [];

    /**
     * Add player
     *
     * @param \Hetwan\Entity\Login\Player $player
     *
     * @return Account
     */
    public function addPlayer(\Hetwan\Entity\Login\Player $player)
    {
        $this->players[$player->getId()] = $player;

        return $this;
    }

    /**
     * Remove player
     *
     * @param \Hetwan\Entity\Login\Player $player
     */
    public function removePlayer(\Hetwan\Entity\Login\Player $player)
    {
        unset($this->players[$player->getId()]);
    }

    /**
     * Get players
     *
     * @return array
     */
    public function getPlayers()
    {
        return $this->players;
    }
}

/**
 * @Table(name="maps_data", indexes={@Index(name="id", columns={"id"})})
 * @Entity
 */
class MapData extends AbstractGameEntity
{
    use MapDataTrait;

    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="date", type="text", nullable=true)
     */
    private $date;

    /**
     * @var integer
     *
     * @Column(name="width", type="integer", nullable=true)
     */
    private $width;

    /**
     * @var integer
     *
     * @Column(name="height", type="integer", nullable=true)
     */
    private $height;

    /**
     * @var string
     *
     * @Column(name="mapData", type="text", nullable=true)
     */
    private $mapData;

    /**
     * @var string
     *
     * @Column(name="decryptedMapData", type="text", nullable=true)
     */
    private $decryptedMapData;

    /**
     * @var string
     *
     * @Column(name="key", type="text", nullable=true)
     */
    private $key;

    /**
     * @var integer
     *
     * @Column(name="x", type="integer", nullable=true)
     */
    private $x;

    /**
     * @var integer
     *
     * @Column(name="y", type="integer", nullable=true)
     */
    private $y;

    /**
     * @var integer
     *
     * @Column(name="subAreaId", type="integer", nullable=true)
     */
    private $subAreaId;

    /**
     * Set id
     *
     * @param integer $id
     *
     * @return MapData
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

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
     * Set date
     *
     * @param string $date
     *
     * @return MapData
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return string
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set width
     *
     * @param integer $width
     *
     * @return MapData
     */
    public function setWidth($width)
    {
        $this->width = $width;

        return $this;
    }

    /**
     * Get width
     *
     * @return integer
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set height
     *
     * @param integer $height
     *
     * @return MapData
     */
    public function setHeight($height)
    {
        $this->height = $height;

        return $this;
    }

    /**
     * Get height
     *
     * @return integer
     */
    public function getHeight()
    {
        return $this->height;
    }

    /**
     * Set mapData
     *
     * @param string $mapData
     *
     * @return MapData
     */
    public function setMapData($mapData)
    {
        $this->mapData = $mapData;

        return $this;
    }

    /**
     * Get mapData
     *
     * @return string
     */
    public function getMapData()
    {
        return $this->mapData;
    }

    /**
     * Set decryptedMapData
     *
     * @param string $decryptedMapData
     *
     * @return MapData
     */
    public function setDecryptedMapData($decryptedMapData)
    {
        $this->decryptedMapData = $decryptedMapData;

        return $this;
    }

    /**
     * Get decryptedMapData
     *
     * @return string
     */
    public function getDecryptedMapData()
    {
        return $this->decryptedMapData;
    }

    /**
     * Set key
     *
     * @param string $key
     *
     * @return MapData
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set x
     *
     * @param integer $x
     *
     * @return MapData
     */
    public function setX($x)
    {
        $this->x = $x;

        return $this;
    }

    /**
     * Get x
     *
     * @return integer
     */
    public function getX()
    {
        return $this->x;
    }

    /**
     * Set y
     *
     * @param integer $y
     *
     * @return MapData
     */
    public function setY($y)
    {
        $this->y = $y;

        return $this;
    }

    /**
     * Get y
     *
     * @return integer
     */
    public function getY()
    {
        return $this->y;
    }

    /**
     * Set subAreaId
     *
     * @param integer $subAreaId
     *
     * @return MapData
     */
    public function setSubAreaId($subAreaId)
    {
        $this->subAreaId = $subAreaId;

        return $this;
    }

    /**
     * Get subAreaId
     *
     * @return integer
     */
    public function getSubAreaId()
    {
        return $this->subAreaId;
    }
}