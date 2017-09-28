<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 10:40:11
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-18 14:49:14
 */

namespace Hetwan\Core;

use React\EventLoop\Factory as LoopFactory;

use Ratchet\Server\IoServer;


class Core
{
	/**
	 * @var \React\EventLoop\Factory
	 */
	protected static $loop;

	public function __construct()
	{
		self::$loop = LoopFactory::create();

		\App\AppKernel::getContainer()->get('database')->load();
	}

	public function makeLoginServer()
	{
		$uri = [
			'address' => \App\AppKernel::getContainer()->get('configuration')->get('network.login.ip'),
			'port' => \App\AppKernel::getContainer()->get('configuration')->get('network.login.port')
		];

		IoServer::factory(
			\App\AppKernel::getContainer()->make('Hetwan\Network\Login\LoginServer'),
			$uri['address'] . ':' . $uri['port'],
			self::$loop
		);
	}

	public function makeExchangeServer()
	{
		$uri = [
			'address' => \App\AppKernel::getContainer()->get('configuration')->get('network.exchange.ip'),
			'port' => \App\AppKernel::getContainer()->get('configuration')->get('network.exchange.port')
		];

		IoServer::factory(
			\App\AppKernel::getContainer()->make('Hetwan\Network\Exchange\ExchangeServer'),
			$uri['address'] . ':' . $uri['port'],
			self::$loop
		);
	}

	public function run()
	{
		self::$loop->run();
	}

	public static function getLoop()
	{
		return self::$loop;
	}
}