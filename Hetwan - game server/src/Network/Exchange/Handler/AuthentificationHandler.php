<?php

/**
 * @Author: jean
 * @Date:   2017-09-12 09:14:33
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 22:05:32
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
		if ($authStatus != ExchangeMessageFormatter::authentificationValidatedMessage())
			return HandlerInterface::FAILED;

		$this->getClient()->setHandler('\Hetwan\Network\Exchange\Handler\ConnectionHandler');

		return HandlerInterface::COMPLETED;
	}
}