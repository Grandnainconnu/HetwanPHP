<?php

namespace Hetwan\Entity\Login;


/**
 * @Entity
 * @Table(name="banned_accounts")
 **/
class BannedAccountEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue 
     */
    private $id;

    /**
     * @Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @Column(type="text", nullable=true)
     */
    private $reason;

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
     * Set endDate.
     *
     * @param \DateTime|null $endDate
     *
     * @return BannedAccountEntity
     */
    public function setEndDate($endDate = null)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate.
     *
     * @return \DateTime|null
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set reason.
     *
     * @param string|null $reason
     *
     * @return BannedAccountEntity
     */
    public function setReason($reason = null)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason.
     *
     * @return string|null
     */
    public function getReason()
    {
        return $this->reason;
    }
}
