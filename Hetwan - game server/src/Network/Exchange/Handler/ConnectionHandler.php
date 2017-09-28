<?php

/**
 * @Author: jean
 * @Date:   2017-09-15 13:13:28
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 16:06:32
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
			case 'T':
				$splittedTicket = explode('|', substr($data, 1));

				$this->getClient()->addTicket($splittedTicket[0], $splittedTicket[1], $splittedTicket[2]);

				break;
		}
	}
}