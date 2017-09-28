<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 21:33:29
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 22:16:55
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
        if (null != ($account = $account =  self::$clientsPool[$conn->resourceId]->getAccount()))
            $account->save();

        unset(self::$clientsPool[$conn->resourceId]);

        AppKernel::getContainer()->get('logger')->debug("({$conn->resourceId}) Client disconnected\n");
    }

    public function onError(ConnectionInterface $conn, \Exception $e) 
    {
    	$conn->close();

        AppKernel::getContainer()->get('logger')->debug("({$conn->resourceId}) Error: {$e}\n");
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
}