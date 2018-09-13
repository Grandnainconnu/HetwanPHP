<?php

use Hetwan\Core\EntityManager;
use Doctrine\ORM\Tools\Console\ConsoleRunner;


/**
 * Declare constants values
 */
const DEBUG = false;
const ROOT = __DIR__;

final class CLIConfig extends \App\AppKernel
{
    public function getEntityManager(string $path, string $prefix = 'database', string $emName = 'default')
	{
		return $this->container->get(EntityManager::class)->create($path, $prefix, $emName);
	}
}

$config = new CLIConfig;
$em = $config->getEntityManager(ROOT . '/src/Entity/Game/', 'database.game');

return ConsoleRunner::createHelperSet($em);