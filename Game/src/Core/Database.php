<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 11:32:57
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 18:28:29
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
	protected $loaders = [
		\Hetwan\Loader\SubAreaDataLoader::class,
		\Hetwan\Loader\MapDataLoader::class
	];

	/**
	 * @Inject({"configuration" = "configuration"})
	 */
	public function __construct($configuration, $entitiesPath)
	{
		$dbLoginParameters = [
			'driver' => 'pdo_mysql',
			'host' => $configuration->get('database.login.host'),
			'user' => $configuration->get('database.login.user'),
			'password' => $configuration->get('database.login.password'),
			'dbname' => $configuration->get('database.login.name')
		];

		$dbGameParameters = [
			'driver' => 'pdo_mysql',
			'host' => $configuration->get('database.game.host'),
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

	public function load()
	{
		foreach ($this->loaders as $loader)
		{
			$loader = new $loader;
			$loader->loadAll();
		}
	}
}