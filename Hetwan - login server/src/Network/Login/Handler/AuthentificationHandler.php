<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 19:16:59
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 23:08:20
 */

namespace Hetwan\Network\Login\Handler;

use Hetwan\Model\AccountModel;

use Hetwan\Network\Handler\HandlerInterface;

use Hetwan\Network\Login\LoginServer;

use Hetwan\Network\Login\Protocol\Formatter\LoginMessageFormatter;


final class AuthentificationHandler extends AbstractLoginHandler
{
	public function handle($packet)
	{
		if (strpos($packet, '#1') != true)
		{
			$this->send(LoginMessageFormatter::wrongIdentificationPacket());

			return HandlerInterface::FAILED;
		}

		$credentials = explode('#', $packet);

		$account = $this->getEntityManager()
						->getRepository('\Hetwan\Entity\Account')
						->findOneByUsername($credentials[0]);

		if (!$account || \Dofus\Crypto::encryptValue($account->getPassword(), $this->getClient()->key) != $credentials[1])
			$this->send(LoginMessageFormatter::identificationFailedMessage());
		elseif (true == $account->getIsBanned())
			$this->send(LoginMessageFormatter::accountBannedMessage());
		else if (null != LoginServer::getClientWithAccount($account->getId()))
			$this->send(LoginMessageFormatter::accountAlreadyConnectedMessage());
		else
		{
			$this->getClient()->setAccount($account->refresh());

			if ($account->getNickname() == null)
				$this->getClient()->setHandler('\Hetwan\Network\Login\Handler\NicknameChoiceHandler');
			else
				$this->getClient()->setHandler('\Hetwan\Network\Login\Handler\GameServerChoiceHandler');

			return HandlerInterface::COMPLETED;
		}

		return HandlerInterface::FAILED;
	}
}