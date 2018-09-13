<?php

namespace Hetwan\Network\Login\Handler\Base;


abstract class Handler extends \Hetwan\Network\Base\Handler\Handler
{
	public function getAccount() : ?\Hetwan\Entity\AccountEntity
	{
		return $this->client->getAccount();
	}
}