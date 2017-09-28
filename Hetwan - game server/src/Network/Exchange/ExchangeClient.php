<?php

/**
 * @Author: jean
 * @Date:   2017-09-08 15:22:56
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-20 13:26:34
 */

namespace Hetwan\Network\Exchange;

use App\AppKernel;

use Hetwan\Network\Exchange\Protocol\Formatter\ExchangeMessageFormatter;


class ExchangeClient extends \Hetwan\Network\AbstractClient
{
	/**
	 * @var int
	 */
	protected $serverState;

	/**
	 * @var array
	 */
	protected static $tickets = [];

	public function __construct(\React\Socket\ConnectionInterface $conn)
	{
		parent::__construct($conn);

		$this->setHandler('\Hetwan\Network\Exchange\Handler\AuthentificationHandler');

		$conn->on('data', [$this, 'onMessage']);
		$conn->on('error', [$this, 'onError']);
		$conn->on('end', [$this, 'onClose']);
	}

	public function onMessage($message)
	{
        $packets = array_filter(
            explode("\n", $message)
        );

    	foreach ($packets as $packet)
    	{
        	AppKernel::getContainer()->get('logger')->debug("(Exchange client) Received packet: {$packet}\n");

            if ($this->handler->handle($packet) == false)
                break;
        }
	}

	public function onError(\Exception $exception)
	{
		$this->connection->close();

		AppKernel::getContainer()->get('logger')->debug("(Exchange client) Error: {$exception->getMessage()}\n");
	}

	public function onClose()
	{
		\Hetwan\Core\Core::getLoop()->stop();

		AppKernel::getContainer()->get('logger')->debug("(Exchange client) Connection closed\n");
	}

	public function send($packet)
	{
		AppKernel::getContainer()->get('logger')->debug("(Exchange client) Sending packet: {$packet}\n");

		$this->connection->write($packet . "\n");
	}

	public function setServer(\Hetwan\Entity\Server &$server)
	{
		$this->server = $server;
	}

	public function getServerState()
	{
		return $this->serverState;
	}

	public function setServerState($state)
	{
		$this->serverState = $state;

		$this->send(ExchangeMessageFormatter::serverStateMessage($state));
	}

	public function addTicket($ticketId, $ipAddress, $accountId)
	{
		self::$tickets[$ticketId] = ['ipAddress' => $ipAddress, 'accountId' => $accountId];
	}

	public static function removeTicket($ticketId)
	{	
		if (!isset(self::$ticketId[$ticketId]))
			return;
		
		unset(self::$tickets[$ticketId]);
	}

	public static function getTicket($ticketId)
	{
		if (!isset(self::$tickets[$ticketId]))
			return null;

		return self::$tickets[$ticketId];
	}
}