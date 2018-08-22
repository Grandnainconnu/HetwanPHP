<?php

/**
 * @Author: jean
 * @Date:   2017-09-16 21:56:45
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 11:31:53
 */

namespace Hetwan\Entity\Game;


/**
 * @Entity 
 * @Table(name="guilds")
 */
class Guild extends AbstractGameEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue 
     */
    protected $id;

    /**
     * @Column(type="text")
     *
     * @var string
     */
    protected $members;
}