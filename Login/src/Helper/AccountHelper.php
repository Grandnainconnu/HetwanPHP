<?php

namespace Hetwan\Helper;


final class AccountHelper
{
    /**
     * @Inject
     * @var \Hetwan\Network\Login\LoginServer
     */
    private $loginServer;

    public function getClient(\Hetwan\Entity\AccountEntity $account) : ?\Hetwan\Network\Login\LoginClient
    {
        $clients = $this->loginServer->getClientsPool();

        foreach ($clients as $client) {
            if (($clientAccount = $client->getAccount()) and $clientAccount === $account) {
                return $client;
            }
        }

        unset($clients);

        return null;
    }

    public function getClientWithId(int $accountId) : ?\Hetwan\Network\Login\LoginClient
    {
        $clients = $this->loginServer->getClientsPool();

        foreach ($clients as $client) {
            if (($clientAccount = $client->getAccount()) and $clientAccount->getId() === $accountId) {
                return $client;
            }
        }

        unset($clients);

        return null;
    }
}