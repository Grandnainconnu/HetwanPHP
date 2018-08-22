<?php

/**
 * @Author: jean
 * @Date:   2017-09-18 13:43:59
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 19:10:14
 */

namespace Hetwan\Loader;


class AbstractLoader
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected static $entityManager;

	/**
	 * @var string
	 */
	protected static $entity;
}