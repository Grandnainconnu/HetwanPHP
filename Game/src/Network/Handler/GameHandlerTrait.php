<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-25 16:36:47
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 16:37:39
 */

namespace Hetwan\Network\Handler;


trait GameHandlerTrait
{
	public function getAccount()
	{
		return $this->getClient()->getAccount();
	}

	public function getPlayer()
	{
		return $this->getClient()->getPlayer();
	}
}