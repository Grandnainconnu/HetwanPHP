<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-25 11:37:52
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 12:07:29
 */

namespace Hetwan\Entity;

/**
 * @Entity
 * @Table(name="banned_accounts")
 **/
class BannedAccount
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue 
     */
    protected $id;

    /**
     * @Column(type="datetime", nullable=true)
     * @var \DateTime
     */
    protected $endDate;

    /**
     * @Column(type="text", nullable=true)
     * @var string
     */
    protected $reason;

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
     * Set endDate
     *
     * @param \DateTime $endDate
     *
     * @return BannedAccount
     */
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get endDate
     *
     * @return \DateTime
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set reason
     *
     * @param string $reason
     *
     * @return BannedAccount
     */
    public function setReason($reason)
    {
        $this->reason = $reason;

        return $this;
    }

    /**
     * Get reason
     *
     * @return string
     */
    public function getReason()
    {
        return $this->reason;
    }
}