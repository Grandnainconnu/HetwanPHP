<?php

/**
 * @Author: jean
 * @Date:   2017-09-08 15:22:56
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 15:44:09
 */

namespace Hetwan\Network\Exchange;

use App\AppKernel;

use Hetwan\Network\Login\LoginServer;

use Hetwan\Network\Exchange\Protocol\Formatter\ExchangeMessageFormatter;


class ExchangeClient extends \Hetwan\Network\AbstractClient
{
	/**
	 * @var \Hetwan\Entity\Server
	 */
	protected $server;

	public function __construct(\Ratchet\ConnectionInterface $conn)
	{
		parent::__construct($conn);

		$this->setHandler('\Hetwan\Network\Exchange\Handler\AuthentificationHandler');
	}

	public function send($packet)
	{
		AppKernel::getContainer()->get('logger')->debug("({$this->connection->resourceId}) Sending packet: {$packet}\n");

		$this->connection->send($packet . "\n");
	}

	public function sendTicket($ticketKey, $ipAddress, $accountId)
	{
		$this->send(ExchangeMessageFormatter::ticketMessage($ticketKey, $ipAddress, $accountId));
	}

	public function setServer(\Hetwan\Entity\Server &$server)
	{
		$this->server = $server;
	}

	public function getServer()
	{
		return $this->server;
	}

	public function setServerState($state)
	{
		if (null == $this->server)
			return;

		$this->server->setState($state);

		foreach (LoginServer::getClientsPool() as $loginClient)
			if (method_exists($loginClient->getHandler(), 'refreshServersList'))
				$loginClient->getHandler()->refreshServersList();
	}
}