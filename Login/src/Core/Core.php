<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 10:40:11
 * @Last Modified by:   Jean Walrave
 * @Last Modified time: 2018-04-11 16:20:11
 */

namespace Hetwan\Core;

use React\EventLoop\Factory as LoopFactory;

use Ratchet\Server\IoServer;

use Hetwan\Loader\ServerLoader;


final class Core
{
	/**
	 * @Inject
	 * @var \DI\Container
	 */
	private $container;

	/**
	 * @Inject
	 * @var \Hetwan\Core\Configuration
	 */
	private $configuration;

	/**
	 * @Inject
	 * @var \Hetwan\Core\EntityManager
	 */
	private $entityManager;

	/**
	 * @Inject
	 * @var \Hetwan\Core\LoaderManager
	 */
	private $loaderManager;

	/**
	 * @Inject
	 * @var \Hetwan\Network\Exchange\ExchangeServer
	 */
	private $exchangeServer;

	/**
	 * @Inject
	 * @var \Hetwan\Network\Login\LoginServer
	 */
	private $loginServer;

	/**
	 * @Inject
	 * @var \Monolog\Logger
	 */
	private $logger;

	/**
	 * @var \React\EventLoop\Factory
	 */
	private $loop;

	public function __construct()
	{
		$this->loop = LoopFactory::create();
	}

	public function initialize() : void
	{
		$this->initalizeEntityManager();
		$this->initializeLoaders();
		$this->initializeServers();

		$this->logger->debug('Core initialized');
	}

	public function run() : void
	{
		$this->loop->run();
	}

	private function initalizeEntityManager() : void
	{
		$this->logger->debug('Initializing entity manager...');

		$this->entityManager->create(ROOT . '/Entity/');

		$this->logger->debug('Entity manager initialized');
	}

	private function initializeLoaders() : void
	{
		$loaders = [
			ServerLoader::class
		];

		foreach ($loaders as $loader) {
			$this->loaderManager->initialize($loader);
		}

		unset($loaders);
	}

	private function initializeServers() : void
	{
		// Initialize exchange server
		$this->logger->debug('Initializing exchange server...');

		IoServer::factory(
			$this->exchangeServer,
			$this->configuration->get('network.exchange.port'),
			$this->configuration->get('network.exchange.ip'),
			$this->loop
		);

		$this->logger->debug('Exchange server initialized');

		// Initialize login server
		$this->logger->debug('Initializing login server...');

		IoServer::factory(
			$this->loginServer,
			$this->configuration->get('network.login.port'),
			$this->configuration->get('network.login.ip'),
			$this->loop
		);

		$this->logger->debug('Login server initialized');
	}

	public function quit() : void
	{
		$this->exchangeServer->onQuit();
		$this->loginServer->onQuit();

		$this->loop->stop();
	}
}