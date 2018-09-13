<?php

namespace Hetwan\Network\Exchange;

use Hetwan\Network\Exchange\Handler\AuthentificationHandler;
use Hetwan\Network\Exchange\Protocol\Formatter\ExchangeMessageFormatter;


final class ExchangeClient extends \Hetwan\Network\Exchange\Base\Client
{
	/**
	 * @var \Hetwan\Entity\Login\Server
	 */
	private $server;

	/**
	 * @var int
	 */
	private $serverState;

	/**
	 * @var array
	 */
	private $tickets = [];

	public function initialize() : void
	{
		$this->setHandler(AuthentificationHandler::class);
	}

	public function addTicket(string $ticketId, string $ipAddress, int $accountId) : void
	{
		$this->tickets[$ticketId] = [
			'ipAddress' => $ipAddress, 
			'accountId' => $accountId
		];
	}

	public function removeTicket(string $ticketId) : void
	{	
		if (isset($this->tickets[$ticketId])) {
			unset($this->tickets[$ticketId]);
		}		
	}

	public function setServer(\Hetwan\Entity\Login\Server &$server) : \Hetwan\Network\Exchange\ExchangeClient
	{
		$this->server = $server;

		return $this;
	}

	public function setServerState(int $state) : \Hetwan\Network\Exchange\ExchangeClient
	{
		$this->serverState = $state;

		$this->send(ExchangeMessageFormatter::serverStateMessage($state));

		return $this;
	}

	public function getTicket(string $ticketId) : ?array
	{
		if (!isset($this->tickets[$ticketId])) {
			return null;
		}

		return $this->tickets[$ticketId];
	}

	public function getServer() : ?\Hetwan\Entity\Login\Server
	{
		return $this->server;
	}

	public function getServerState() : ?int
	{
		return $this->serverState;
	}
}