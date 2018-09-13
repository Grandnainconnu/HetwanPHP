<?php

namespace Hetwan\Entity\Game;


/**
 * @Entity
 * @Table(name="jobs")
 */
class JobEntity
{
    /**
     * @Id
     * @Column(type="integer", nullable=false)
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="PlayerEntity", inversedBy="jobs")
     * @JoinColumn(name="playerId", referencedColumnName="id")
     */
    private $player;

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
     * Set player.
     *
     * @param \Hetwan\Entity\Game\PlayerEntity|null $player
     *
     * @return JobEntity
     */
    public function setPlayer(\Hetwan\Entity\Game\PlayerEntity $player = null)
    {
        $this->player = $player;

        return $this;
    }

    /**
     * Get player.
     *
     * @return \Hetwan\Entity\Game\PlayerEntity|null
     */
    public function getPlayer()
    {
        return $this->player;
    }
}
