<?php

namespace Hetwan\Network\Game\Base\Handler;


abstract class HandlerContainer implements \Hetwan\Network\Base\Handler\HandlerInterface
{
	/**
	 * @Inject
	 * @var \DI\Container
	 */
	protected $container;

	/**
	 * @var \Hetwan\Network\Game\GameClient
	 */
	protected $client;

    /**
     * @var array
     */
	protected $handlers = [];

	public function __construct(\Hetwan\Network\Game\GameClient $client)
	{
		$this->client = $client;
	}

	public function initialize() : void
	{
		;
	}

	protected function addHandler(string $prefix, string $handler) : object
	{
		$this->handlers[$prefix] = $this->container->make($handler, ['client' => $this->client]);

		return $this;
	}

	public function send($data) : void
	{
		if (is_array($data)) {
			foreach ($data as $packet) {
				$this->client->send($packet);
			}
		} else {
			$this->client->send($data);
		}
	}

	public function handle($data) : bool
	{
		if (isset($this->handlers[($prefix = $data[0])])) {
			return $this->handlers[$prefix]->handle(substr($data, 1));
		}

		return false;
	}
}