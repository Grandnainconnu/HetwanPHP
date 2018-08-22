<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 19:17:42
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-17 23:16:28
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

	public function handle($data)
	{
		;
	}

	public function onClose()
	{
		;
	}

	protected function send($data)
	{
		return $this->client->send($data);
	}

	protected function log($level, $message)
	{
		$this->getContainer()->get('logger')->$level(
			(
				($account = $this->getClient()->getAccount()) 
				?
					'<Account ' . $account->getId() . '>'
				: 
					'<Connection ' . $this->getClient()->getConnection()->resourceId . '>'
			) . ' ' .$message
		);
	}

	protected function getLoginEntityManager()
	{
		return AppKernel::getContainer()->get('database')->getLoginEntityManager();
	}

	protected function getGameEntityManager()
	{
		return AppKernel::getContainer()->get('database')->getGameEntityManager();
	}

	protected function getContainer()
	{
		return AppKernel::getContainer();
	}

	protected function getClient()
	{
		return $this->client;
	}
}