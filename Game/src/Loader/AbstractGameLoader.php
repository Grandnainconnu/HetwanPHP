<?php

/**
 * @Author: jean
 * @Date:   2017-09-18 13:43:59
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 19:06:26
 */

namespace Hetwan\Loader;

use App\AppKernel;


class AbstractGameLoader extends AbstractLoader
{
	public function __construct()
	{
		self::$entityManager = AppKernel::getContainer()->get('database')->getGameEntityManager();
	}
}