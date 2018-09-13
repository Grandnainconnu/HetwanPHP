<?php

namespace Hetwan\Entity\Game;


/**
 * @Entity
 * @Table(name="subareas_data", indexes={@Index(name="id", columns={"id"})})
 */
class SubAreaDataEntity
{
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     */
    private $id;

    /**
     * @Column(type="integer", nullable=false)
     */
    private $areaId;

    /**
     * @Column(type="integer", nullable=true, options={"default":"0"})
     */
    private $factionId;

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return SubAreaDataEntity
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
     * Set areaId.
     *
     * @param int $areaId
     *
     * @return SubAreaDataEntity
     */
    public function setAreaId($areaId)
    {
        $this->areaId = $areaId;

        return $this;
    }

    /**
     * Get areaId.
     *
     * @return int
     */
    public function getAreaId()
    {
        return $this->areaId;
    }

    /**
     * Set factionId.
     *
     * @param int|null $factionId
     *
     * @return SubAreaDataEntity
     */
    public function setFactionId($factionId = null)
    {
        $this->factionId = $factionId;

        return $this;
    }

    /**
     * Get factionId.
     *
     * @return int|null
     */
    public function getFactionId()
    {
        return $this->factionId;
    }
}
