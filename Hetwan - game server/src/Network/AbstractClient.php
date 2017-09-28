<?php

/**
 * @Author: jean
 * @Date:   2017-09-13 18:22:42
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-15 23:58:40
 */

namespace Hetwan\Network;

use App\AppKernel;


class AbstractClient
{
	/**
	 * @var \Ratchet\ConnectionInterface
	 */
	protected $connection;

	/**
	 * @var \Hetwan\Network\Handler\HandlerInterface
	 */
	protected $handler;

	public function __construct($connection)
	{
		$this->connection = $connection;
	}

	public function setHandler($handler, array $parameters = [])
	{
		$parameters = array_merge($parameters, ['client' => $this]);

		$this->handler = AppKernel::getContainer()->make($handler, $parameters);
		$this->handler->initialize();
	}

	public function getHandler()
	{
		return $this->handler;
	}

	public function handle($message)
	{
		$failed = $this->handler->handle($message) == \Hetwan\Network\Handler\HandlerInterface::FAILED;

		if ($failed)
			$this->connection->close();

		return $failed != true;
	}

	public function getConnection()
	{
		return $this->connection;
	}
}