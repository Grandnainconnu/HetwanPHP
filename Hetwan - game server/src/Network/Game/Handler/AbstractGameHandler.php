<?php

/**
 * @Author: jean
 * @Date:   2017-09-17 21:20:55
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 21:39:35
 */

namespace Hetwan\Network\Game\Handler;

use Hetwan\Network\Handler\AbstractHandler;


abstract class AbstractGameHandler extends AbstractHandler
{
	public function getAccount()
	{
		return $this->getClient()->getAccount();
	}
}