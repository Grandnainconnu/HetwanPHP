<?php

/**
 * @Author: jean
 * @Date:   2017-09-12 10:13:06
 * @Last Modified by:   Jean Walrave
 * @Last Modified time: 2018-04-11 14:09:03
 */

namespace Hetwan\Network\Exchange\Handler;

use Hetwan\Network\Exchange\Protocol\Formatter\ExchangeMessageFormatter;


final class GameServerHandler extends \Hetwan\Network\Base\Handler\Handler
{
	public function handle($message) : bool
	{
		if (substr($message, 0, 1) !== 'S') {
			return false;
		}

		switch (substr($message, 1, 1)) {
			case 'u':
				$this->client->setServerState((int) (substr($message, 2)));

				break;
		}

		return true;
	}
}