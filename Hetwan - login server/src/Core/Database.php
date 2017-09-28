<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 11:32:57
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-18 14:49:10
 */

namespace Hetwan\Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;


class Database
{
	/**
	 * @var \Doctrine\ORM\EntityManager
	 */
	protected $entityManager;

	/**
	 * @var array
	 */
	protected $loaders = [
		\Hetwan\Loader\ServerLoader::class
	];

	/**
	 * @Inject({"configuration" = "configuration"})
	 */
	public function __construct($configuration, $entitiesPath)
	{
		$dbParameters = [
			'driver' => 'pdo_mysql',
			'user' => $configuration->get('database.user'),
			'password' => $configuration->get('database.password'),
			'dbname' => $configuration->get('database.name')
		];

		$this->entityManager = EntityManager::create($dbParameters, Setup::createAnnotationMetadataConfiguration([$entitiesPath], DEBUG));
	}

	public function getEntityManager()
	{
		return $this->entityManager;
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