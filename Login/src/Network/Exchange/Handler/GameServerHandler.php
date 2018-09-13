<?php

namespace Hetwan\Network\Exchange\Handler;


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