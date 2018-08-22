<?php

/**
 * @Author: jean
 * @Date:   2017-09-12 09:14:33
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-18 14:50:39
 */

namespace Hetwan\Network\Exchange\Handler;

use Hetwan\Loader\ServerLoader;
use Hetwan\Network\Exchange\Protocol\Formatter\ExchangeMessageFormatter;


final class AuthentificationHandler extends \Hetwan\Network\Base\Handler\Handler
{
	public function initialize() : void
	{
		$this->send(ExchangeMessageFormatter::helloConnectMessage());
	}

	public function handle(string $authMessage) : bool
	{
		if (!preg_match('/^(\d+)\|(.*?)\|(.*?):(\d+)/', substr($authMessage, 2), $matches) or 
			($server = $this->loaderManager->get(ServerLoader::class)->getBy(['id' => $matches[1]], $assertCount = false, $first = true)) === null or
			$server->getKey() !== $matches[2]) {
			$this->send(ExchangeMessageFormatter::authentificationFailedMessage());

			return false;
		}

		$this->send(ExchangeMessageFormatter::authentificationValidatedMessage());

		$server->setIpAddress($matches[3])
			   ->setPort($matches[4]);

		$this->client->setServer($server)
					 ->setHandler(GameServerHandler::class);

		$this->logger->debug("Game server {$server->getKey()} added !\n");

		return true;
	}
}