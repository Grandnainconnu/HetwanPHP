<?php

namespace Hetwan\Helper;

use Hetwan\Entity\Game\PlayerEntity;


final class AccountHelper
{
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

    public function hasPlayer(int $playerId, iterable $accountPlayers, bool $returnEntity = false)
    {
        foreach ($accountPlayers as $serverId) {
            foreach ($serverId as $player) {
                if ($player === $playerId) {
                    if ($returnEntity) {
                        return $this->entityManager->get()
                                                   ->getRepository(PlayerEntity::class)
                                                   ->findOneById($playerId);
                    }

                    return true;
                }
            }
        }

        return null;
    }

    public function getPlayers(int $accountId) : iterable
    {
        return $this->entityManager->get()
                                   ->getRepository(PlayerEntity::class)
                                   ->findByAccountId($accountId);
    }

    public function getClient(\Hetwan\Entity\Login\AccountEntity $account) : ?\Hetwan\Network\Game\GameClient
    {
        $clients = $this->gameServer->getClientsPool();

        foreach ($clients as $client) {
            if (($clientAccount = $client->getAccount()) and $clientAccount === $account) {
                return $client;
            }
        }

        unset($clients);

        return null;
    }

    public function getClientWithId(int $accountId) : ?\Hetwan\Network\Game\GameClient
    {
        $clients = $this->gameServer->getClientsPool();

        foreach ($clients as $client) {
            if (($clientAccount = $client->getAccount()) and $clientAccount->getId() === $accountId) {
                return $client;
            }
        }

        unset($clients);

        return null;
    }
}