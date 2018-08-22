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
	 * @var \Ratchet\ConnectionInterface
	 */
	protected $connection;

	/**
	 * @var \Hetwan\Network\Handler\HandlerInterface
	 */
	protected $handler;

	/**
	 * @var string
	 */
	protected $baseHandler = Handler::class;

	public function __construct(\Ratchet\ConnectionInterface $conn)
	{
		$this->connection = $conn;
	}

	public function handle($message) : bool
	{
		if (!isset($this->handler)) {
			$this->setHandler($this->baseHandler);
		}

		if ($this->handler->handle($message) === false) {
			$this->connection->close();

			return false;
		}

		return true;
	}

	public function setHandler($handler, array $parameters = []) : \Hetwan\Network\Base\Client
	{
		$parameters = array_merge($parameters, ['client' => $this]);

		($this->handler = $this->container->make($handler, $parameters))->initialize();

		return $this;
	}

	public function getHandler() : object
	{
		return $this->handler;
	}

	public function getConnection() : \Ratchet\ConnectionInterface
	{
		return $this->connection;
	}
}