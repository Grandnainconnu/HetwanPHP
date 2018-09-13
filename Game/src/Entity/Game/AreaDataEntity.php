<?php

namespace Hetwan\Entity\Game;


/**
 * @Entity
 * @Table(name="areas_data", indexes={@Index(name="id", columns={"id"})})
 */
class AreaDataEntity
{
    /**
     * @Id
     * @Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * @Column(name="superAreaId", type="integer", nullable=false)
     */
    private $superAreaId;

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return AreaDataEntity
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
     * Set superAreaId.
     *
     * @param int $superAreaId
     *
     * @return AreaDataEntity
     */
    public function setSuperAreaId($superAreaId)
    {
        $this->superAreaId = $superAreaId;

        return $this;
    }

    /**
     * Get superAreaId.
     *
     * @return int
     */
    public function getSuperAreaId()
    {
        return $this->superAreaId;
    }
}
