<?php

/**
 * @Author: jean
 * @Date:   2017-09-08 15:30:21
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-18 15:07:02
 */

namespace Hetwan\Network\Exchange;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

use App\AppKernel;


class ExchangeServer implements MessageComponentInterface 
{    
    /**
     * @var array
     */
    protected static $clientsPool = [];

    public function __construct()
    {
        AppKernel::getContainer()->get('logger')->debug("Exchange server started !\n");
    }

    public function onOpen(ConnectionInterface $conn)
    {
        AppKernel::getContainer()->get('logger')->debug("({$conn->resourceId}) Game server connected\n");

        self::$clientsPool[$conn->resourceId] = AppKernel::getContainer()->make('Hetwan\Network\Exchange\ExchangeClient', ['conn' => $conn]);
    }

    public function onMessage(ConnectionInterface $conn, $message)
    {
        $packets = array_filter(
            explode("\n", $message)
        );

    	foreach ($packets as $packet)
    	{
        	AppKernel::getContainer()->get('logger')->debug("({$conn->resourceId}) Received packet: {$packet}\n");

            if (self::$clientsPool[$conn->resourceId]->handle($packet) == false)
                break;
        }
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
    	AppKernel::getContainer()->get('logger')->debug("({$conn->resourceId}) Error: {$e}\n");
    }

    public function onClose(ConnectionInterface $conn)
    {
        self::$clientsPool[$conn->resourceId]->setServerState(0);

        unset(self::$clientsPool[$conn->resourceId]);

        AppKernel::getContainer()->get('logger')->debug("({$conn->resourceId}) Game server disconnected\n");
    }

    public static function getClientsPool()
    {
        return self::$clientsPool;
    }

    public static function getServerWithId($serverId)
    {
        foreach (self::$clientsPool as $client)
            if (($server = $client->getServer()) && $server->getId() == $serverId)
                return $client;
    }
}