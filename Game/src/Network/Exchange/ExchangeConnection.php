<?php

namespace Hetwan\Network\Exchange;

use React\Socket\Connector;


final class ExchangeConnection
{
    /**
	 * @Inject
	 * @var \DI\Container
	 */
	private $container;
    
    /**
	 * @Inject
	 * @var \React\EventLoop\LoopInterface
	 */
    private $loop;

    /**
	 * @Inject
	 * @var \Hetwan\Core\Configuration
	 */
    private $configuration;

    /**
	 * @Inject
	 * @var \Monolog\Logger
	 */
	private $logger;

    /**
     * @var \Hetwan\Network\Exchange\ExchangeClient
     */
    private $client;

    public function initialize()
    {
        $this->logger->debug('Initializing exchange connection...');

        (new Connector($this->loop, [
            'timeout' => $this->configuration->get('network.exchange.timeout'),
            'dns' => false
        ]))->connect($this->configuration->get('network.exchange.ip') . ':' . $this->configuration->get('network.exchange.port'))->then(
            function (\React\Socket\ConnectionInterface $connection) {
                $this->client = $this->container->make(ExchangeClient::class, ['conn' => $connection]);
                $this->client->initialize();

                $this->logger->debug('Exchange connection initialized');
            },
            function (\Exception $exception) {
                $this->logger->error('Unable to start exchange connection !');
            }
        );
    }

    public function removeClient() : \Hetwan\Network\Exchange\ExchangeConnection
    {
        $this->client = null;

        return $this;
    }

    public function getClient() : ?\Hetwan\Network\Exchange\ExchangeClient
    {
        return $this->client;
    }

    public function isAlive() : bool
    {
        return ($this->client and $this->client->getConnection()->isReadable());
    }
}