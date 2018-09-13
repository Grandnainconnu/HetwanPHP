<?php

namespace Hetwan\Network\Exchange\Base;


abstract class Client extends \Hetwan\Network\Base\Client
{
	public function __construct(\React\Socket\ConnectionInterface $conn)
	{
		parent::__construct($conn);

		$conn->on('data', [$this, 'onMessage']);
		$conn->on('error', [$this, 'onError']);
		$conn->on('end', [$this, 'onClose']);
	}

	public function onMessage($message) : void
	{
        $packets = array_filter(explode(PHP_EOL, $message));

    	foreach ($packets as $packet) {
        	$this->logger->debug("(Exchange client) Received packet: {$packet}\n");

            if ($this->handle($packet) === false) {
				break;
			}
        }
	}

	public function onError(\Exception $exception) : void
	{
		$this->logger->debug("(Exchange client) Error: {$exception->getMessage()}\n");
	}

	public function onClose() : void
	{
		$this->logger->debug("(Exchange client) Connection closed\n");
	}

	public function send(string $packet) : void
	{
		$this->logger->debug("(Exchange client) Sending packet: {$packet}\n");

		$this->connection->write($packet . PHP_EOL);
	}
}