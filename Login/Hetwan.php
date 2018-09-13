<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 09:24:55
 * @Last Modified by:   Jean Walrave
 * @Last Modified time: 2018-03-31 21:57:10
 */

/**
 * Declare constants values
 */
const DEBUG = false;
const ROOT = __DIR__;

use Hetwan\Core\Core;

require ROOT . '/vendor/autoload.php';


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