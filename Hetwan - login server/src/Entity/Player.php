<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 19:01:40
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 23:03:11
 */

namespace Hetwan\Entity;

/**
 * @Entity 
 * @Table(name="players")
 **/
class Player extends AbstractEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue 
     */
    protected $id;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $serverId;

    /**
     * @ManyToOne(targetEntity="Account", inversedBy="players")
     * @JoinColumn(name="accountId", referencedColumnName="id")
     */
    protected $account;

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
     * Set serverId
     *
     * @param integer $serverId
     *
     * @return Player
     */
    public function setServerId($serverId)
    {
        $this->serverId = $serverId;

        return $this;
    }

    /**
     * Get serverId
     *
     * @return integer
     */
    public function getServerId()
    {
        return $this->serverId;
    }

    /**
     * Set account
     *
     * @param \Hetwan\Entity\Login\Account $account
     *
     * @return Player
     */
    public function setAccount(\Hetwan\Entity\Login\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \Hetwan\Entity\Login\Account
     */
    public function getAccount()
    {
        return $this->account;
    }
}