<?php

namespace Hetwan\Core;

use Ratchet\Server\IoServer;



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
	 * @var \Hetwan\Network\Game\GameServer
	 */
	private $gameServer;

	/**
	 * @Inject
	 * @var \Hetwan\Network\Exchange\ExchangeConnection
	 */
	private $exchangeConnection;

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
	    //$this->initializeDoctrineEvents();
		$this->initalizeEntityManager();
		$this->initializeServers();

		$this->logger->debug('Core initialized');
	}

	public function run()
	{
		$this->loop->run();
	}

	public function quit() : void
	{
		$this->gameServer->onQuit();

		$this->loop->stop();
	}

	/*
	private function initializeDoctrineEvents() : void
    {
        $subscribers = [
            MetadataEventSubscriber::class,
        ];

        foreach ($subscribers as $subscriber) {
            $this->doctrineEventManager->addEventSubscriber($this->container->make($subscriber));
        }

        unset($subscribers);
    }
	*/

	private function initalizeEntityManager() : void
	{
		$this->logger->debug('Initializing entity manager...');

		$this->entityManager->create(ROOT . '/Entity/Login', $prefix = 'database.login', $name = 'login');
		$this->entityManager->create(ROOT . '/Entity/Game', $prefix = 'database.game');

		$this->logger->debug('Entity manager initialized');
	}

	private function initializeServers() : void
	{
		// Initialize game server
		$this->logger->debug('Initializing game server...');

		IoServer::factory(
			$this->gameServer,
			$this->configuration->get('network.game.port'),
			$this->configuration->get('network.game.ip'),
			$this->loop
		);

		$this->logger->debug('Game server initialized');

		// Initialize exchange connection
		$this->exchangeConnection->initialize();

		$this->loop->addPeriodicTimer($this->configuration->get('network.exchange.timeout') + 1, function () {
			if (!$this->exchangeConnection->isAlive()) {
				$this->exchangeConnection->removeClient()
										 ->initialize();
			}
		});
	}
}