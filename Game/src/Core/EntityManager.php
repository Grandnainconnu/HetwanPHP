<?php

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
     * @Inject
     * @var \Doctrine\Common\EventManager
     */
    private $eventManager;

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

		return ($this->entityManagers[$name] = DoctrineEntityManager::create($dbParameters, Setup::createAnnotationMetadataConfiguration([$entitiesPath], DEBUG), $this->eventManager));
	}

	public function get(string $emName = 'default') : \Doctrine\ORM\EntityManager
	{
		if (!isset($this->entityManagers[$emName])) {
			throw new EntityManagerException("Unable to get {$emName} entity manager.\n");
		}

		return $this->entityManagers[$emName];
	}

	public function refresh(object $entity, string $emName = 'default') : object
    {
        $this->get($emName)->refresh($entity);

        return $entity;
    }

	public function persist(object $entity, string $emName = 'default') : object
    {
        $this->get($emName)->persist($entity);

        return $entity;
    }

    public function remove(object $entity, string $emName = 'default') : object
    {
        $this->get($emName)->remove($entity);

        return $entity;
    }

    public function flush(string $emName = 'default') : void
    {
        $this->get($emName)->flush();
    }
}

class EntityManagerException extends \Exception {}