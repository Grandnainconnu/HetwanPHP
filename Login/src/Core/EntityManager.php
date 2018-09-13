<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 11:32:57
 * @Last Modified by:   Jean Walrave
 * @Last Modified time: 2018-04-11 22:38:29
 */

namespace Hetwan\Core;

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager as DoctrineEntityManager;


final class EntityManager
{
	/**
	 * @Inject
	 * @var \Hetwan\Core\Configuration
	 */
	private $configuration;

	/**
	 * @var array
	 */
	private $entityManagers = [];

	public function create(string $entitiesPath, string $prefix = 'database', string $name = 'default') : \Doctrine\ORM\EntityManager
	{
		$dbParameters = [
			'driver' => 'pdo_mysql',
			'host' => $this->configuration->get("{$prefix}.host"),
			'user' => $this->configuration->get("{$prefix}.user"),
			'password' => $this->configuration->get("{$prefix}.password"),
			'dbname' => $this->configuration->get("{$prefix}.name")
		];

		return ($this->entityManagers[$name] = DoctrineEntityManager::create($dbParameters, Setup::createAnnotationMetadataConfiguration([$entitiesPath], DEBUG)));
	}

	public function get($emName = 'default') : \Doctrine\ORM\EntityManager
	{
		if (!isset($this->entityManagers[$emName])) {
			throw new EntityManagerException("Unable to get {$emName} entity manager.\n");
		}

		return $this->entityManagers[$emName];
	}

    public function refresh(object $entity, string $emName = 'default') : object
    {
        $this->get($emName)->refresh($entity);
        $this->get($emName)->flush();

        return $entity;
    }

    public function persist(object $entity, string $emName = 'default') : object
    {
        $this->get($emName)->persist($entity);
        $this->get($emName)->flush();

        return $entity;
    }

    public function remove(object $entity, string $emName = 'default') : object
    {
        $this->get($emName)->remove($entity);
        $this->get($emName)->flush();

        return $entity;
    }
}

class EntityManagerException extends \Exception {}