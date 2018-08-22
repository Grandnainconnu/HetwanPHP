<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 21:33:29
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-16 15:40:48
 */

namespace Hetwan\Network\Game;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use App\AppKernel;


class GameServer implements MessageComponentInterface 
{
    /**
     * @var array
     */
    protected static $clientsPool = [];

    public function __construct()
    {
        AppKernel::getContainer()->get('logger')->debug("Game server started !\n");
    }

    public function onOpen(ConnectionInterface $conn)
    {
        AppKernel::getContainer()->get('logger')->debug("({$conn->resourceId}) Client connected\n");

        self::$clientsPool[$conn->resourceId] = AppKernel::getContainer()->make('Hetwan\Network\Game\GameClient', ['conn' => $conn]);
    }

    public function onMessage(ConnectionInterface $conn, $message) 
    {
        $packets = array_filter(
            explode("\n", 
                str_replace(chr(0), "\n",
                    str_replace("\n", '', $message)
                )
            )
        );

        foreach ($packets as $packet)
        {
            AppKernel::getContainer()->get('logger')->debug("({$conn->resourceId}) Received packet: {$packet}\n");

            if (self::$clientsPool[$conn->resourceId]->handle($packet) == false)
                break;
        }
    }

    public function onClose(ConnectionInterface $conn) 
    {
        self::removeClient($conn);

        AppKernel::getContainer()->get('logger')->debug("({$conn->resourceId}) Client disconnected\n");
    }

    public function onError(ConnectionInterface $conn, \Exception $e) 
    {
    	$conn->close();

        AppKernel::getContainer()->get('logger')->debug("({$conn->resourceId}) Error: {$e}\n");
    }

    public static function removeClient(ConnectionInterface $conn)
    {
        if (null != ($account = ($client = self::$clientsPool[$conn->resourceId])->getAccount()))
        {
            $account
                ->setIsOnline(false)
                ->save();

            $client->getHandler()->onClose();
        }

        unset(self::$clientsPool[$conn->resourceId]);

        AppKernel::getContainer()->get('logger')->debug("({$conn->resourceId}) Client removed\n");
    }

    public static function getClientsPool()
    {
        return self::$clientsPool;
    }

    public static function getClientWithAccount($accountId)
    {
        foreach (self::$clientsPool as $client)
            if (null != ($account = $client->getAccount()) && $account->getId() == $accountId)
                return $client;
    }

    public static function getClientWithPlayer($playerId)
    {
        foreach (self::$clientsPool as $client)
            if (($player = $client->getPlayer()) != null && $player->getId() == $playerId)
                return $client;
    }

    public static function getClientWithPlayerName($playerName)
    {
        foreach (self::$clientsPool as $client)
            if (($player = $client->getPlayer()) != null && $player->getName() == $playerName)
                return $client;
    }

    public static function sendToAllPlayersInMap(int $mapId, $message, array $exceptId = [])
    {
        foreach (self::$clientsPool as $client)
            if (($player = $client->getPlayer()) != null && $player->getMapId() == $mapId && !in_array($player->getId(), $exceptId))
                $client->send($message);
    }

    public static function close()
    {
        foreach (self::$clientsPool as $client)
        {
            self::removeClient($client->getConnection());

            $client->getConnection()->close();
        }

        AppKernel::getContainer()->get('logger')->debug("Game server shutted down.\n");
    }
}