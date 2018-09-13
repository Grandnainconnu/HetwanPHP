<?php

namespace Hetwan\Entity\Game;


/**
 * @Entity
 * @Table(name="scripted_cells_data")
 */
class ScriptedCellDataEntity
{
	/**
     * @Id
     * @Column(type="integer", nullable=false)
     */
    private $mapId;

    /**
     * @Id
     * @Column(type="integer", nullable=false)
     */
    private $cellId;

    /**
     * @Column(type="integer", nullable=false)
     */
    private $actionId;

    /**
     * @Column(type="integer", nullable=false)
     */
    private $eventId;

    /**
     * @Column(type="text")
     */
    private $actionArguments;

    /**
     * @Column(type="text")
     */
    private $conditions;

    /**
     * Set mapId.
     *
     * @param int $mapId
     *
     * @return ScriptedCellDataEntity
     */
    public function setMapId($mapId)
    {
        $this->mapId = $mapId;

        return $this;
    }

    /**
     * Get mapId.
     *
     * @return int
     */
    public function getMapId()
    {
        return $this->mapId;
    }

    /**
     * Set cellId.
     *
     * @param int $cellId
     *
     * @return ScriptedCellDataEntity
     */
    public function setCellId($cellId)
    {
        $this->cellId = $cellId;

        return $this;
    }

    /**
     * Get cellId.
     *
     * @return int
     */
    public function getCellId()
    {
        return $this->cellId;
    }

    /**
     * Set actionId.
     *
     * @param int $actionId
     *
     * @return ScriptedCellDataEntity
     */
    public function setActionId($actionId)
    {
        $this->actionId = $actionId;

        return $this;
    }

    /**
     * Get actionId.
     *
     * @return int
     */
    public function getActionId()
    {
        return $this->actionId;
    }

    /**
     * Set eventId.
     *
     * @param int $eventId
     *
     * @return ScriptedCellDataEntity
     */
    public function setEventId($eventId)
    {
        $this->eventId = $eventId;

        return $this;
    }

    /**
     * Get eventId.
     *
     * @return int
     */
    public function getEventId()
    {
        return $this->eventId;
    }

    /**
     * Set actionArguments.
     *
     * @param string $actionArguments
     *
     * @return ScriptedCellDataEntity
     */
    public function setActionArguments($actionArguments)
    {
        $this->actionArguments = $actionArguments;

        return $this;
    }

    /**
     * Get actionArguments.
     *
     * @return string
     */
    public function getActionArguments()
    {
        return $this->actionArguments;
    }

    /**
     * Set conditions.
     *
     * @param string $conditions
     *
     * @return ScriptedCellDataEntity
     */
    public function setConditions($conditions)
    {
        $this->conditions = $conditions;

        return $this;
    }

    /**
     * Get conditions.
     *
     * @return string
     */
    public function getConditions()
    {
        return $this->conditions;
    }
}
