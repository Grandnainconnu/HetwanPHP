<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 11:32:57
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-22 19:13:52
 */

namespace Hetwan\Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


class Database
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $loginEntityManager;

	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $gameEntityManager;

	/**
	 * @var array
	 */
	protected $repositories = [];

	/**
	 * @Inject({"configuration" = "configuration"})
	 */
	public function __construct($configuration, $entitiesPath)
	{
		$dbLoginParameters = [
			'driver' => 'pdo_mysql',
			'user' => $configuration->get('database.login.user'),
			'password' => $configuration->get('database.login.password'),
			'dbname' => $configuration->get('database.login.name')
		];

		$dbGameParameters = [
			'driver' => 'pdo_mysql',
			'user' => $configuration->get('database.game.user'),
			'password' => $configuration->get('database.game.password'),
			'dbname' => $configuration->get('database.game.name')
		];

		$this->loginEntityManager = EntityManager::create(
			$dbLoginParameters, 
			Setup::createAnnotationMetadataConfiguration([$entitiesPath . 'Login'], DEBUG)
		);

		$this->gameEntityManager = EntityManager::create(
			$dbGameParameters, 
			Setup::createAnnotationMetadataConfiguration([$entitiesPath . 'Game'], DEBUG)
		);
	}

	public function getLoginEntityManager()
	{
		return $this->loginEntityManager;
	}

	public function getGameEntityManager()
	{
		return $this->gameEntityManager;
	}

	public function loadRepositories()
	{
		foreach ($this->repositories as $repository)
		{
			$repository = new $repository;
			$repository->loadAll();
		}
	}
}