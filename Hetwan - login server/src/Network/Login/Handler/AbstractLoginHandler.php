<?php

/**
 * @Author: jean
 * @Date:   2017-09-17 23:07:35
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 23:07:58
 */

namespace Hetwan\Network\Login\Handler;

use Hetwan\Network\Handler\AbstractHandler;


abstract class AbstractLoginHandler extends AbstractHandler
{
	public function getAccount()
	{
		return $this->getClient()->getAccount();
	}
}