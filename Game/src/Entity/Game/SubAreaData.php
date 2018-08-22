<?php

/**
 * @Author: jean
 * @Date:   2017-09-16 21:56:45
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-24 15:45:42
 */

namespace Hetwan\Entity\Game;


/**
 * @Table(name="subareas_data", indexes={@Index(name="id", columns={"id"})})
 * @Entity
 */
class SubAreaData extends AbstractGameEntity
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     */
    private $id;

    /**
     * @var integer
     *
     * @Column(name="areaId", type="integer", nullable=false)
     */
    private $areaId;

    /**
     * @var integer
     *
     * @Column(name="factionId", type="integer", nullable=true, options={"default":"0"})
     */
    private $factionId;

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
     * Set areaId
     *
     * @param integer $areaId
     *
     * @return SubAreaData
     */
    public function setAreaId($areaId)
    {
        $this->areaId = $areaId;

        return $this;
    }

    /**
     * Get areaId
     *
     * @return integer
     */
    public function getAreaId()
    {
        return $this->areaId;
    }

    /**
     * Set factionId
     *
     * @param integer $factionId
     *
     * @return SubAreaData
     */
    public function setFactionId($factionId)
    {
        $this->factionId = $factionId;

        return $this;
    }

    /**
     * Get factionId
     *
     * @return integer
     */
    public function getFactionId()
    {
        return $this->factionId;
    }
}