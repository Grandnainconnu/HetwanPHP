<?php

/**
 * @Author: jean
 * @Date:   2017-09-15 13:13:28
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 12:52:20
 */

namespace Hetwan\Network\Exchange\Handler;

use Hetwan\Network\Handler\HandlerInterface;
use Hetwan\Network\Handler\AbstractHandler;

use Hetwan\Network\Exchange\Protocol\Formatter\ExchangeMessageFormatter;


final class ConnectionHandler extends AbstractHandler
{
	public function initialize()
	{
		$this->getClient()->setServerState(1);
	}

	public function handle($data)
	{
		switch (substr($data, 0, 1))
		{
			case 'A': // Force disconnect account
				if (substr($data, 0, 2) != 'Ad')
					return;

				$accountId = substr($data, 2);

				$client = \Hetwan\Network\Game\GameServer::getClientWithAccount($accountId);

				if (null != $client)
				{
					\Hetwan\Network\Game\GameServer::removeClient($client->getConnection());
					$client->getConnection()->close();
				}

				break;
			case 'T': // Account ticket
				$splittedTicket = explode('|', substr($data, 1));

				$this->getClient()->addTicket($splittedTicket[0], $splittedTicket[1], $splittedTicket[2]);

				break;
		}
	}
}