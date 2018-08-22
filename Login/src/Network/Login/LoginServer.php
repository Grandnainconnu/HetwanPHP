<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 21:33:29
 * @Last Modified by:   Jean Walrave
 * @Last Modified time: 2018-04-12 15:07:02
 */

namespace Hetwan\Network\Login;

use Hetwan\Network\Login\LoginClient;


trait ClientsPoolManagerTrait
{
    public function getClientWithAccount($accountId) : ?\Hetwan\Network\Login\LoginClient
    {
        foreach ($this->clientsPool as $client) {
            if (($account = $client->getAccount()) !== null and $account->getId() == $accountId) {
                return $client;
            }
        }

        return null;
    }
}

final class LoginServer extends \Hetwan\Network\Base\Server
{
    use ClientsPoolManagerTrait;

    public function onOpen(\Ratchet\ConnectionInterface $conn) : void
    {
        $this->logger->debug("({$conn->resourceId}) Client connected\n");

        $this->clientsPool[$conn->resourceId] = $this->container->make(LoginClient::class, ['conn' => $conn]);
        $this->clientsPool[$conn->resourceId]->initialize();
    }

    public function onMessage(\Ratchet\ConnectionInterface $conn, $message) : void
    {
        $packets = array_filter(
            explode("\n", 
                str_replace(chr(0), "\n", 
                    str_replace("\n", '', $message)
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
            $em = $this->entityManager->get();

            $em->persist($account);
            $em->flush();

            unset($em);
        }

        unset($this->clientsPool[$conn->resourceId]);

        $this->logger->debug("({$conn->resourceId}) Client disconnected\n");
    }
}