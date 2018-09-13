<?php

namespace Hetwan\Entity;


/**
 * @Entity
 * @Table(name="servers")
 **/
class ServerEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    private $id;

    /**
     * @Column(type="string", unique=true)
     */
    private $key;

    /**
     * @Column(type="integer")
     */
    private $requireSubscription;

    /**
     * @var int
     */
    private $state = 0;

    /**
     * @var int
     */
    private $population = 0;

    /**
     * @var string
     */
    private $ipAddress;

    /**
     * @var int
     */
    private $port;

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
     * Set key.
     *
     * @param string $key
     *
     * @return ServerEntity
     */
    public function setKey($key)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Get key.
     *
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * Set requireSubscription.
     *
     * @param int $requireSubscription
     *
     * @return ServerEntity
     */
    public function setRequireSubscription($requireSubscription)
    {
        $this->requireSubscription = $requireSubscription;

        return $this;
    }

    /**
     * Get requireSubscription.
     *
     * @return int
     */
    public function getRequireSubscription()
    {
        return $this->requireSubscription;
    }

    /* POST GENERATION METHODS */

    /**
     * Set state
     *
     * @param int $state
     * @return \Hetwan\Entity\ServerEntity
     */
    public function setState(int $state) : \Hetwan\Entity\ServerEntity
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Set population
     *
     * @param int $population
     * @return \Hetwan\Entity\ServerEntity
     */
    public function setPopulation(int $population) : \Hetwan\Entity\ServerEntity
    {
        $this->population = $population;

        return $this;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     * @return \Hetwan\Entity\ServerEntity
     */
    public function setIpAddress(string $ipAddress) : \Hetwan\Entity\ServerEntity
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Set port
     *
     * @param int $port
     * @return \Hetwan\Entity\ServerEntity
     */
    public function setPort($port) : \Hetwan\Entity\ServerEntity
    {
        $this->port = $port;

        return $this;
    }

    /**
     * Get state
     *
     * @return int
     */
    public function getState() : int
    {
        return $this->state;
    }

    /**
     * Get population
     *
     * @return int
     */
    public function getPopulation() : int
    {
        return $this->population;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress() : string
    {
        return $this->ipAddress;
    }

    /**
     * Get port
     *
     * @return int
     */
    public function getPort() : int
    {
        return $this->port;
    }
}
