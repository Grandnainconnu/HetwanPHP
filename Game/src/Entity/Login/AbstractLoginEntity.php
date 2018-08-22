<?php

/**
 * @Author: jean
 * @Date:   2017-09-17 21:29:33
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-24 11:41:13
 */

namespace Hetwan\Entity\Login;

use Hetwan\Entity\AbstractEntity;


abstract class AbstractLoginEntity extends AbstractEntity
{
	protected function getEntityManager()
	{
		return \App\AppKernel::getContainer()->get('database')->getLoginEntityManager();
	}
}