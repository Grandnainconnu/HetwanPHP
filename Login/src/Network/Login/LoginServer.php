<?php

namespace Hetwan\Network\Login;


final class LoginServer extends \Hetwan\Network\Base\Server
{
    public function onOpen(\Ratchet\ConnectionInterface $conn) : void
    {
        $this->logger->debug("({$conn->resourceId}) Client connected\n");

        $this->clientsPool[$conn->resourceId] = $this->container->make(LoginClient::class, ['conn' => $conn]);
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
        if (($account = $this->clientsPool[$conn->resourceId]->getAccount()) !== null) {
            $this->entityManager->persist($account);
        }

        unset($this->clientsPool[$conn->resourceId]);

        $this->logger->debug("({$conn->resourceId}) Client disconnected\n");
    }
}