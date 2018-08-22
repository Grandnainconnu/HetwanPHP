<?php

/**
 * @Author: jean
 * @Date:   2017-09-16 21:56:45
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-20 15:30:53
 */

namespace Hetwan\Entity\Game;


/**
 * @Table(name="experience_data")
 * @Entity
 */
class ExperienceData extends AbstractGameEntity
{
    /**
     * @var integer
     *
     * @Column(name="level", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $level;

    /**
     * @var integer
     *
     * @Column(name="player", type="bigint", nullable=false)
     */
    private $player;

    /**
     * @var integer
     *
     * @Column(name="job", type="bigint", nullable=false)
     */
    private $job;

    /**
     * @var integer
     *
     * @Column(name="mount", type="bigint", nullable=false)
     */
    private $mount;

    /**
     * @var integer
     *
     * @Column(name="faction", type="integer", nullable=false)
     */
    private $faction;

   /**
     * Get level
     *
     * @return integer
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set player
     *
     * @param integer $player
     *
     * @return ExperienceData
     */
    public function setPlayer($player)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player
     *
     * @return integer
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * Set job
     *
     * @param integer $job
     *
     * @return ExperienceData
     */
    public function setJob($job)
    {
        $this->job = $job;

        return $this;
    }

    /**
     * Get job
     *
     * @return integer
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set mount
     *
     * @param integer $mount
     *
     * @return ExperienceData
     */
    public function setMount($mount)
    {
        $this->mount = $mount;

        return $this;
    }

    /**
     * Get mount
     *
     * @return integer
     */
    public function getMount()
    {
        return $this->mount;
    }

    /**
     * Set faction
     *
     * @param integer $faction
     *
     * @return ExperienceData
     */
    public function setFaction($faction)
    {
        $this->faction = $faction;

        return $this;
    }

    /**
     * Get faction
     *
     * @return integer
     */
    public function getFaction()
    {
        return $this->faction;
    }
}