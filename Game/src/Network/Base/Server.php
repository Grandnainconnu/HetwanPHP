<?php

namespace Hetwan\Network\Base;


abstract class Server implements \Ratchet\MessageComponentInterface
{
    /**
     * @Inject
     * @var \DI\Container
     */
    protected $container;

    /**
     * @Inject
     * @var \Hetwan\Core\EntityManager
     */
    protected $entityManager;

    /**
     * @Inject
     * @var \Monolog\Logger
     */
    protected $logger;

    /**
     * @var array
     */
    protected $clientsPool = [];

    public function onError(\Ratchet\ConnectionInterface $conn, \Exception $e) : void
    {
        $conn->close();

        unset($this->clientsPool[$conn->resourceId]);

    	$this->logger->debug("({$conn->resourceId}) Error: {$e}\n");
    }

    public function onQuit() : void
    {
        foreach ($this->clientsPool as $client) {
            $this->onClose($client->getConnection());
        }
    }

    public function getClientsPool() : array
    {
        return $this->clientsPool;
    }
}