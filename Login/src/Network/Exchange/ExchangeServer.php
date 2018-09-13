<?php

namespace Hetwan\Network\Exchange;


trait ClientsPoolManagerTrait
{
    public function getServerWithId(int $serverId) : ?\Hetwan\Network\Exchange\ExchangeClient
    {
        foreach ($this->clientsPool as $client) {
            if (($server = $client->getServer()) and $server->getId() === $serverId) {
                return $client;
            }
        }

        return null;
    }
}

final class ExchangeServer extends \Hetwan\Network\Base\Server
{
    use ClientsPoolManagerTrait;

    public function onOpen(\Ratchet\ConnectionInterface $conn) : void
    {
        $this->logger->debug("({$conn->resourceId}) Game server connected\n");

        $this->clientsPool[$conn->resourceId] = $this->container->make(ExchangeClient::class, ['conn' => $conn]);
        $this->clientsPool[$conn->resourceId]->initialize();
    }

    public function onMessage(\Ratchet\ConnectionInterface $conn, $message) : void
    {
        $packets = array_filter(explode(PHP_EOL, $message));

    	foreach ($packets as $packet) {
        	$this->logger->debug("({$conn->resourceId}) Received packet: {$packet}\n");

            if ($this->clientsPool[$conn->resourceId]->handle($packet) === false) {
                break;
            }
        }
    }

    public function onClose(\Ratchet\ConnectionInterface $conn) : void
    {
        $this->clientsPool[$conn->resourceId]->setServerState(0);

        unset($this->clientsPool[$conn->resourceId]);

        $this->logger->debug("({$conn->resourceId}) Game server disconnected\n");
    }
}