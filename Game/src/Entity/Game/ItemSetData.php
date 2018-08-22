<?php

/**
 * @Author: jean
 * @Date:   2017-09-16 21:56:45
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 11:32:36
 */

namespace Hetwan\Entity\Game;


/**
 * @Table(name="itemsets_data")
 * @Entity
 */
class ItemSetData extends AbstractGameEntity
{
    /**
     * @var integer
     *
     * @Column(name="id", type="integer", nullable=false)
     * @Id
     * @GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(name="name", type="text", nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @Column(name="objectsId", type="text", nullable=false)
     */
    private $objectsid;

    /**
     * @var string
     *
     * @Column(name="effects", type="text", nullable=true)
     */
    private $effects;

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
     * Set name
     *
     * @param string $name
     *
     * @return ItemSetData
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set objectsid
     *
     * @param string $objectsid
     *
     * @return ItemSetData
     */
    public function setObjectsid($objectsid)
    {
        $this->objectsid = $objectsid;

        return $this;
    }

    /**
     * Get objectsid
     *
     * @return string
     */
    public function getObjectsid()
    {
        return $this->objectsid;
    }

    /**
     * Set effects
     *
     * @param string $effects
     *
     * @return ItemSetData
     */
    public function setEffects($effects)
    {
        $this->effects = $effects;

        return $this;
    }

    /**
     * Get effects
     *
     * @return string
     */
    public function getEffects()
    {
        return $this->effects;
    }
}