<?php

namespace Hetwan\Entity\Game;


/**
 * @Entity(repositoryClass="Hetwan\Repository\ExperienceDataRepository")
 * @Table(name="experience_data")
 */
class ExperienceDataEntity
{
    /**
     * @Id
     * @Column(name="level", type="integer", nullable=false)
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $level;

    /**
     * @Column(type="bigint", nullable=false)
     */
    private $player;

    /**
     * @Column(type="bigint", nullable=false)
     */
    private $job;

    /**
     * @Column(type="bigint", nullable=false)
     */
    private $mount;

    /**
     * @Column(type="integer", nullable=false)
     */
    private $faction;

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
     * Set player.
     *
     * @param int $player
     *
     * @return ExperienceDataEntity
     */
    public function setPlayer($player)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player.
     *
     * @return int
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set job.
     *
     * @param int $job
     *
     * @return ExperienceDataEntity
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job.
     *
     * @return int
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set mount.
     *
     * @param int $mount
     *
     * @return ExperienceDataEntity
     */
    public function setMount($mount)
    {
        $this->mount = $mount;

        return $this;
    }

    /**
     * Get mount.
     *
     * @return int
     */
    public function getMount()
    {
        return $this->mount;
    }

    /**
     * Set faction.
     *
     * @param int $faction
     *
     * @return ExperienceDataEntity
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
}
