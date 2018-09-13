<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 19:17:42
 * @Last Modified by:   Jean Walrave
 * @Last Modified time: 2018-04-12 11:43:40
 */

namespace Hetwan\Network\Base\Handler;


abstract class Handler implements \Hetwan\Network\Base\Handler\HandlerInterface
{
	/**
	 * @Inject
	 * @var \Hetwan\Core\Configuration
	 */
	protected $configuration;

	/**
	 * @Inject
	 * @var \Hetwan\Core\EntityManager
	 */
	protected $entityManager;

	/**
	 * @Inject
	 * @var \Monolog\Logger
	 */
	protected $logger;

	/**
	 * @var object
	 */
	protected $client;

	public function __construct(object $client)
	{
		$this->client = $client;
	}

	public function initialize() : void
	{
		;
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
}