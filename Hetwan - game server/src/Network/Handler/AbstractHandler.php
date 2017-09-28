<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 19:17:42
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 21:20:14
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
		return $this->client->send($data);
	}

	public function getLoginEntityManager()
	{
		return AppKernel::getContainer()->get('database')->getLoginEntityManager();
	}

	public function getGameEntityManager()
	{
		return AppKernel::getContainer()->get('database')->getGameEntityManager();
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