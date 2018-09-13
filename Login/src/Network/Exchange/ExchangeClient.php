<?php

/**
 * @Author: jean
 * @Date:   2017-09-08 15:22:56
 * @Last Modified by:   Jean Walrave
 * @Last Modified time: 2018-04-11 13:24:37
 */

namespace Hetwan\Network\Exchange;

use Hetwan\Network\Exchange\Handler\AuthentificationHandler;
use Hetwan\Network\Exchange\Protocol\Formatter\ExchangeMessageFormatter;


final class ExchangeClient extends \Hetwan\Network\Base\Client
{
	/**
	 * @Inject
	 * @var \Hetwan\Network\Login\LoginServer
	 */
	private $loginServer;

	/**
	 * @var string
	 */
	protected $baseHandler = AuthentificationHandler::class;
	
	/**
	 * @var \Hetwan\Entity\ServerEntity
	 */
	private $server;

	public function send($packet) : void
	{
		$this->logger->debug("({$this->connection->resourceId}) Sending packet: {$packet}\n");

		$this->connection->send($packet . "\n");
	}

	public function sendTicket(string $ticketKey, string $ipAddress, int $accountId) : void
	{
		$this->send(ExchangeMessageFormatter::accountTicketMessage($ticketKey, $ipAddress, $accountId));
	}

	public function setServer(\Hetwan\Entity\ServerEntity &$server) : \Hetwan\Network\Exchange\ExchangeClient
	{
		$this->server = $server;

		return $this;
	}

	public function setServerState(int $state) : \Hetwan\Network\Exchange\ExchangeClient
	{
		if ($this->server !== null) {
			$this->server->setState($state);

			$clientsPool = $this->loginServer->getClientsPool();

			foreach ($clientsPool as $client) {
				if (method_exists($client->getHandler(), 'refreshServersList')) {
					$client->getHandler()->refreshServersList();
				}
			}

			unset($clientsPool);
		}

		return $this;
	}

	public function getServer() : ?\Hetwan\Entity\ServerEntity
	{
		return $this->server;
	}
}