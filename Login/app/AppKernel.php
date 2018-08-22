<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 09:18:58
 * @Last Modified by:   Jean Walrave
 * @Last Modified time: 2018-04-12 15:08:12
 */

namespace App;

use DI\ContainerBuilder;
use function DI\{create, get, autowire, factory};

use Monolog\Logger;


class AppKernel
{
	/**
	 * @var \DI\ContainerBuilder
	 */
	protected $containerBuilder;

	/**
	 * @var \DI\Container
	 */
	protected $container;

	public function __construct()
	{
		$this->makeContainerBuilder();
		$this->buildDependencies();

		$this->container = $this->containerBuilder->build();
	}

	private function makeContainerBuilder()
	{
		$containerBuilder = new ContainerBuilder();
		$containerBuilder->useAutowiring(true);
		$containerBuilder->useAnnotations(true);

		$this->containerBuilder = $containerBuilder;
	}

	private function buildDependencies()
	{
		$this->containerBuilder->addDefinitions([
			\Hetwan\Core\Configuration::class => create()->constructor(ROOT . '/app/config/config.yml'),
			\Hetwan\Core\EntityManager::class => autowire(),
			\Hetwan\Core\LoaderManager::class => autowire(),
			\Hetwan\Network\Exchange\ExchangeServer::class => autowire(),
			\Hetwan\Network\Login\LoginServer::class => autowire(),
			\Monolog\Logger::class => factory(function () {
		    	$logger = new Logger('HetwanPHP');

		    	return $logger;
			}),
		]);
	}
}