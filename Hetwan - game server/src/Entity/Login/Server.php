<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 19:01:40
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-18 14:58:02
 */

namespace Hetwan\Entity\Login;

/**
 * @Entity
 * @Table(name="servers")
 **/
class Server extends AbstractLoginEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue 
     */
    protected $id;

    /**
     * @Column(type="string", unique=true)
     * @var string
     */
    protected $key;

    /**
     * @Column(type="integer")
     * @var int
     */
    protected $requireSubscription;

    /**
     * @var int
     */
    protected $state = 0;

    /**
     * @var int
     */
    protected $population = 0;

    /**
     * @var string
     */
    protected $ipAddress;

    /**
     * @var int
     */
    protected $port;

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
     * Set key
     *
     * @param string $key
     *
     * @return Server
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set requireSubscription
     *
     * @param integer $requireSubscription
     *
     * @return Server
     */
    public function setRequireSubscription($requireSubscription)
    {
        $this->requireSubscription = $requireSubscription;

        return $this;
    }

    /**
     * Get requireSubscription
     *
     * @return integer
     */
    public function getRequireSubscription()
    {
        return $this->requireSubscription;
    }

    /**
     * Set state
     *
     * @param integer $state
     *
     * @return Server
     */
    public function setState($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return integer
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set population
     *
     * @param integer $population
     *
     * @return Server
     */
    public function setPopulation($population)
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Get population
     *
     * @return integer
     */
    public function getPopulation()
    {
        return $this->population;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return Server
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set port
     *
     * @param integer $port
     *
     * @return Server
     */
    public function setPort($port)
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get port
     *
     * @return integer
     */
    public function getPort()
    {
        return $this->port;
    }
}