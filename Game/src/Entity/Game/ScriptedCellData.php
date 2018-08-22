<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-23 15:29:55
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-23 16:06:47
 */

namespace Hetwan\Entity\Game;


/**
 * @Table(name="scripted_cells_data")
 * @Entity
 */
class ScriptedCellData extends AbstractGameEntity
{
	/**
     * @var integer
     *
     * @Column(type="integer", nullable=false)
     * @Id
     */
    protected $mapId;

    /**
     * @var integer
     *
     * @Column(type="integer", nullable=false)
     * @Id
     */
    protected $cellId;

    /**
     * @var integer
     *
     * @Column(type="integer", nullable=false)
     */
    protected $actionId;

    /**
     * @var integer
     *
     * @Column(type="integer", nullable=false)
     */
    protected $eventId;

    /**
     * @Column(type="text")
     *
     * @var string
     */
    protected $actionArguments;

    /**
     * @Column(type="text")
     *
     * @var string
     */
    protected $conditions;

    /**
     * Set mapId
     *
     * @param integer $mapId
     *
     * @return ScriptedCellData
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
     * Set cellId
     *
     * @param integer $cellId
     *
     * @return ScriptedCellData
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
     * Set actionId
     *
     * @param integer $actionId
     *
     * @return ScriptedCellData
     */
    public function setActionId($actionId)
    {
        $this->actionId = $actionId;

        return $this;
    }

    /**
     * Get actionId
     *
     * @return integer
     */
    public function getActionId()
    {
        return $this->actionId;
    }

    /**
     * Set eventId
     *
     * @param integer $eventId
     *
     * @return ScriptedCellData
     */
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;

        return $this;
    }

    /**
     * Get eventId
     *
     * @return integer
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * Set actionArguments
     *
     * @param string $actionArguments
     *
     * @return ScriptedCellData
     */
    public function setActionArguments($actionArguments)
    {
        $this->actionArguments = $actionArguments;

        return $this;
    }

    /**
     * Get actionArguments
     *
     * @return string
     */
    public function getActionArguments()
    {
        return $this->actionArguments;
    }

    /**
     * Set conditions
     *
     * @param string $conditions
     *
     * @return ScriptedCellData
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
}