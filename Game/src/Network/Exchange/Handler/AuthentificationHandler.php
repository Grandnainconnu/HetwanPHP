<?php

/**
 * @Author: jean
 * @Date:   2017-09-12 09:14:33
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 12:29:23
 */

namespace Hetwan\Network\Exchange\Handler;

use Hetwan\Network\Handler\HandlerInterface;
use Hetwan\Network\Handler\AbstractHandler;

use Hetwan\Network\Exchange\Protocol\Formatter\ExchangeMessageFormatter;


final class AuthentificationHandler extends AbstractHandler
{
	public function initialize()
	{
		$this->send(ExchangeMessageFormatter::helloConnectMessage(
			$this->getContainer()->get('configuration')->get('server.id'),
			$this->getContainer()->get('configuration')->get('server.key'),
			$this->getContainer()->get('configuration')->get('network.game.ip'),
			$this->getContainer()->get('configuration')->get('network.game.port')
		));
	}

	public function handle($authStatus)
	{
		if ($authStatus != 'Av')
			return HandlerInterface::FAILED;

		$this->getClient()->setHandler('\Hetwan\Network\Exchange\Handler\ConnectionHandler');

		return HandlerInterface::COMPLETED;
	}
}