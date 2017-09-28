<?php

/**
 * @Author: jean
 * @Date:   2017-09-18 13:43:59
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-22 00:17:22
 */

namespace Hetwan\Loader;


class AbstractLoader
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $entityManager;

	/**
	 * @var string
	 */
	protected $entity;

	/**
	 * @var array
	 */
	protected static $values;

	public function __construct()
	{
		$this->entityManager = \App\AppKernel::getContainer()->get('database')->getEntityManager();
	}

	public function loadAll()
	{
		self::$values = $this->entityManager->getRepository($this->entity)->findAll();
	}
}