<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 09:24:55
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 18:30:19
 */

ini_set('memory_limit', '-1');

/**
 * Declare constants values
 */
const DEBUG = false;
const ROOT = __DIR__;

use Hetwan\Core\Core;

require __DIR__.'/vendor/autoload.php';


final class Hetwan extends \App\AppKernel
{
	/**
	 * @var \Hetwan\Core\Core
	 */
	private $core;

	public function __construct()
	{
		parent::__construct();

		$this->core = $this->container->make(Core::class);
	}

	public function run() : void
	{
		$this->core->initialize();
		$this->core->run();
	}
}

$runner = new Hetwan;
$runner->run();