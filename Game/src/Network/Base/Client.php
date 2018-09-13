<?php

/**
 * @Author: jean
 * @Date:   2017-09-13 18:22:42
 * @Last Modified by:   Jean Walrave
 * @Last Modified time: 2018-04-11 13:24:09
 */

namespace Hetwan\Network\Base;


abstract class Client
{
	/**
	 * @Inject
	 * @var \DI\Container
	 */
	protected $container;

    /**
     * @Inject
     * @var \Monolog\Logger
     */
    protected $logger;

	/**
	 * @var object
	 */
	protected $connection;

	/**
	 * @var object
	 */
	protected $handler;

	/**
	 * @var string
	 */
	protected $baseHandler;

	public function __construct(object $conn)
	{
		$this->connection = $conn;
	}

	public function handle(string $message) : bool
	{
		if (!$this->handler and $this->baseHandler) {
			$this->setHandler($this->baseHandler);
		}

		if ($this->handler->handle($message) === false) {
			//$this->connection->close();

			$this->logger->debug("Unable to handle packet {$message}, closing connection.");

			return false;
		}

		return true;
	}

	public function setHandler(string $handler, array $parameters = []) : object
	{
		$parameters = array_merge($parameters, ['client' => $this]);

		($this->handler = $this->container->make($handler, $parameters))->initialize();

		return $this;
	}

	public function getHandler() : object
	{
		return $this->handler;
	}

	public function getConnection() : object
	{
		return $this->connection;
	}
}