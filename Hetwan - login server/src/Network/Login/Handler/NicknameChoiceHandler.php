<?php

/**
 * @Author: jean
 * @Date:   2017-09-07 13:17:36
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 23:09:36
 */

namespace Hetwan\Network\Login\Handler;

use Hetwan\Network\Handler\HandlerInterface;

use Hetwan\Network\Login\Protocol\Formatter\LoginMessageFormatter;


final class NicknameChoiceHandler extends AbstractLoginHandler
{
	public function initialize()
	{
		$this->send(LoginMessageFormatter::emptyAccountNickname());
	}

	public function handle($nickname = null)
	{
		if ($nickname == 'Af' || $nickname == null)
			return;

		$accounts = $this->getEntityManager()
						 ->getRepository('\Hetwan\Entity\Account')
						 ->findByNickname($nickname);

		if (false == empty($accounts))
			$this->send(LoginMessageFormatter::notAvailableAccountNickname());
		else
		{
			$this->getClient()
				 ->getAccount()
				 ->setNickname($nickname)
				 ->save();

			$this->getClient()->setHandler('\Hetwan\Network\Login\Handler\GameServerChoiceHandler');
		}
	}
}