<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 21:33:29
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-16 15:40:48
 */

namespace Hetwan\Network\Game;


trait ClientsPoolManagerTrait
{
    public function removeClient(\Ratchet\ConnectionInterface $conn) : void
    {
        if (($client = $this->clientsPool[$conn->resourceId])->getAccount() !== null) {
            $client->getAccount()->setIsOnline(false);

            $this->entityManager->persist($client->getAccount(), 'login');

            if (($player = $client->getPlayer()) !== null) {
                $client->getHandler()->onClose();
            }
        }

        unset($this->clientsPool[$conn->resourceId]);

        $this->logger->debug("({$conn->resourceId}) Client removed\n");
    }
}

final class GameServer extends \Hetwan\Network\Base\Server 
{
    use ClientsPoolManagerTrait;

    public function onOpen(\Ratchet\ConnectionInterface $conn) : void
    {
        $this->logger->debug("({$conn->resourceId}) Client connected\n");

        $this->clientsPool[$conn->resourceId] = $this->container->make(GameClient::class, ['conn' => $conn]);
        $this->clientsPool[$conn->resourceId]->initialize();
    }

    public function onMessage(\Ratchet\ConnectionInterface $conn, $message) : void
    {
        $packets = array_filter(
            explode(PHP_EOL,
                str_replace(chr(0), PHP_EOL,
                    str_replace(PHP_EOL, '', $message)
                )
            )
        );

        foreach ($packets as $packet) {
            $this->logger->debug("({$conn->resourceId}) Received packet: {$packet}\n");

            if ($this->clientsPool[$conn->resourceId]->handle($packet) === false) {
                break;
            }
        }
    }

    public function onClose(\Ratchet\ConnectionInterface $conn) : void
    {
        $this->removeClient($conn);

        $this->logger->debug("({$conn->resourceId}) Client disconnected\n");
    }
}