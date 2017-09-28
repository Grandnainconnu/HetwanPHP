<?php

/**
 * @Author: jean
 * @Date:   2017-09-22 00:14:34
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-22 16:27:18
 */

namespace Hetwan\Helper;


abstract class AbstractHelper
{
	/**
	 * @return \Doctrine\ORM\EntityManager
	 */
	protected static function getLoginEntityManager()
	{
		return \App\AppKernel::getContainer()->get('database')->getLoginEntityManager();
	}

	/**
	 * @return \Doctrine\ORM\EntityManager
	 */
	protected static function getGameEntityManager()
	{
		return \App\AppKernel::getContainer()->get('database')->getGameEntityManager();
	}
}