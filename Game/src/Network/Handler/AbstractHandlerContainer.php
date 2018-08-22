<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-20 18:26:34
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-26 23:24:41
 */

namespace Hetwan\Network\Handler;

use App\AppKernel;


abstract class AbstractHandlerContainer extends AbstractHandler implements HandlerContainerInterface
{
	protected $client;
	protected $handlers = [];

	public function __construct($client)
	{
		$this->client = $client;
	}

	public function initialize()
	{
		;
	}

	protected function initializeHandlers()
	{
		foreach ($this->handlers as $handler)
			$handler->initialize();
	}

	protected function addHandler($prefix, $handler)
	{
		$this->handlers[$prefix] = new $handler($this->client);

		return $this;
	}
}