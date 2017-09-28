<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 19:17:42
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-15 10:36:08
 */

namespace Hetwan\Network\Handler;

use App\AppKernel;


abstract class AbstractHandler implements HandlerInterface
{
	protected $client;

	public function __construct($client)
	{
		$this->client = $client;
	}

	public function initialize()
	{
		;
	}

	public function send($data)
	{
		if (is_array($data))
			foreach ($data as $packet)
				$this->client->send($packet);
		else
			$this->client->send($data);
	}

	public function getEntityManager()
	{
		return AppKernel::getContainer()->get('database')->getEntityManager();
	}

	public function getContainer()
	{
		return AppKernel::getContainer();
	}

	public function getClient()
	{
		return $this->client;
	}
}