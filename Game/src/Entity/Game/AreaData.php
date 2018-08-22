<?php

/**
 * @Author: jean
 * @Date:   2017-09-16 21:56:45
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-20 16:31:19
 */

namespace Hetwan\Entity\Game;


/**
 * @Table(name="areas_data", indexes={@Index(name="id", columns={"id"})})
 * @Entity
 */
class AreaData extends AbstractGameEntity
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
     * @Column(name="superAreaId", type="integer", nullable=false)
     */
    private $superAreaId;

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
     * Set superAreaId
     *
     * @param integer $superAreaId
     *
     * @return AreaData
     */
    public function setSuperAreaId($superAreaId)
    {
        $this->superAreaId = $superAreaId;

        return $this;
    }

    /**
     * Get superAreaId
     *
     * @return integer
     */
    public function getSuperAreaId()
    {
        return $this->superAreaId;
    }
}

