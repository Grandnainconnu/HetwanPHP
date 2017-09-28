<?php

/**
 * @Author: jean
 * @Date:   2017-09-16 21:56:45
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-21 23:48:04
 */

namespace Hetwan\Entity\Game;

/**
 * @Entity 
 * @Table(name="guilds")
 **/
class Guild
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue 
     */
    protected $id;

    /**
     * @Column(type="string")
     *
     * @var string
     */
    protected $members;
}