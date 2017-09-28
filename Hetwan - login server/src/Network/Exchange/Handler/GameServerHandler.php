<?php

/**
 * @Author: jean
 * @Date:   2017-09-12 10:13:06
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 15:43:49
 */

namespace Hetwan\Network\Exchange\Handler;

use Hetwan\Network\Handler\HandlerInterface;
use Hetwan\Network\Handler\AbstractHandler;

use Hetwan\Network\Exchange\Protocol\Formatter\ExchangeMessageFormatter;


final class GameServerHandler extends AbstractHandler
{
	public function handle($message)
	{
		if (substr($message, 0, 1) != 'S')
			return HandlerInterface::FAILED;

		switch (substr($message, 1, 1))
		{
			case 'u':
				$this->getClient()->setServerState(intval(substr($message, 2)));

				break;
		}
	}
}