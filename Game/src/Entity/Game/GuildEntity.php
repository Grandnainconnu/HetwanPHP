<?php

namespace Hetwan\Entity\Game;


/**
 * @Entity 
 * @Table(name="guilds")
 */
class GuildEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue 
     */
    private $id;

    /**
     * @OneToMany(targetEntity="PlayerEntity", mappedBy="guildId")
     */
    private $members;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->members = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Add member.
     *
     * @param \Hetwan\Entity\Game\PlayerEntity $member
     *
     * @return GuildEntity
     */
    public function addMember(\Hetwan\Entity\Game\PlayerEntity $member)
    {
        $this->members[] = $member;

        return $this;
    }

    /**
     * Remove member.
     *
     * @param \Hetwan\Entity\Game\PlayerEntity $member
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeMember(\Hetwan\Entity\Game\PlayerEntity $member)
    {
        return $this->members->removeElement($member);
    }

    /**
     * Get members.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMembers()
    {
        return $this->members;
    }
}
