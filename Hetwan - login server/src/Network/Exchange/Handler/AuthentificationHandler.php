<?php

/**
 * @Author: jean
 * @Date:   2017-09-12 09:14:33
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-18 14:50:39
 */

namespace Hetwan\Network\Exchange\Handler;

use Hetwan\Network\Handler\HandlerInterface;
use Hetwan\Network\Handler\AbstractHandler;

use Hetwan\Network\Exchange\Protocol\Formatter\ExchangeMessageFormatter;


final class AuthentificationHandler extends AbstractHandler
{
	public function initialize()
	{
		$this->send(ExchangeMessageFormatter::helloConnectMessage());
	}

	public function handle($authMessage)
	{
		if (!preg_match('/^(\d+)\|(.*?)\|(.*?):(\d+)/', substr($authMessage, 2), $matches) || null == ($server = \Hetwan\Loader\ServerLoader::findById($matches[1])) || $server->getKey() != $matches[2])
		{
			$this->send(ExchangeMessageFormatter::authentificationFailedMessage());

			return HandlerInterface::FAILED;
		}

		$this->send(ExchangeMessageFormatter::authentificationValidatedMessage());

		$server
			->setIpAddress($matches[3])
			->setPort($matches[4]);

		$this->getClient()->setServer($server);

		$this->getClient()->setHandler('\Hetwan\Network\Exchange\Handler\GameServerHandler');

		return HandlerInterface::COMPLETED;
	}
}