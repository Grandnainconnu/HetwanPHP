<?php

namespace Hetwan\Network\Exchange\Handler;

use Hetwan\Network\Exchange\Protocol\Formatter\ExchangeMessageFormatter;


final class AuthentificationHandler extends \Hetwan\Network\Base\Handler\Handler
{
	public function initialize() : void
	{
		$this->send(ExchangeMessageFormatter::helloConnectMessage(
			$this->configuration->get('server.id'),
			$this->configuration->get('server.key'),
			$this->configuration->get('network.game.ip'),
			$this->configuration->get('network.game.port')
		));
	}

	public function handle(string $authStatus) : bool
	{
		if ($authStatus !== 'Av') {
			return false;
		}

		$this->client->setHandler(ConnectionHandler::class);

		return true;
	}
}