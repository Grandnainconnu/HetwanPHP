<?php

/**
 * @Author: jean
 * @Date:   2017-09-17 23:07:35
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 23:07:58
 */

namespace Hetwan\Network\Login\Handler\Base;


abstract class Handler extends \Hetwan\Network\Base\Handler\Handler
{
	public function getAccount() : ?\Hetwan\Entity\Account
	{
		return $this->client->getAccount();
	}
}