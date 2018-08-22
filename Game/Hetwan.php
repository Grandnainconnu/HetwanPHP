<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 09:24:55
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 18:30:19
 */

ini_set('memory_limit', '-1');

define('DEBUG', false);

require __DIR__.'/vendor/autoload.php';


class Hetwan extends \App\AppKernel
{
	private $core;

	public function __construct()
	{
		parent::__construct();

		$this->core = new \Hetwan\Core\Core();
	}

	public function run()
	{
		$this->core->makeExchangeClient();
		$this->core->makeGameServer();

		$this->core->run();
	}

	public function getCore()
	{
		return $this->core;
	}
}

$hetwan = new Hetwan;

$hetwan->run();