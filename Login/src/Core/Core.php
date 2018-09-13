<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 10:40:11
 * @Last Modified by:   Jean Walrave
 * @Last Modified time: 2018-04-11 16:20:11
 */

namespace Hetwan\Core;

use Ratchet\Server\IoServer;

use Hetwan\Loader\ServerLoader;


final class Core
{
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
	 * @Inject
	 * @var \React\EventLoop\LoopInterface
	 */
	private $loop;

	public function initialize() : void
	{
		$this->initalizeEntityManager();
		$this->initializeServers();
		$this->initializeLoopSignals();

		$this->logger->debug('Core initialized');
	}

	public function run() : void
	{
		$this->loop->run();
	}

	public function quit() : void
	{
		$this->exchangeServer->onQuit();
		$this->loginServer->onQuit();

		$this->loop->stop();

		$this->logger->debug('Loop stopped');
	}

	private function initalizeEntityManager() : void
	{
		$this->logger->debug('Initializing entity manager...');

		$this->entityManager->create(ROOT . '/Entity/Login/');

		$this->logger->debug('Entity manager initialized');
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

	private function initializeLoopSignals() : void
	{
		$this->loop->addSignal(SIGINT, function (int $signal) {
			$this->quit();
		});
	}
}