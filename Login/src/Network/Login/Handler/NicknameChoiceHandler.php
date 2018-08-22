<?php

/**
 * @Author: jean
 * @Date:   2017-09-07 13:17:36
 * @Last Modified by:   Jean Walrave
 * @Last Modified time: 2018-04-11 14:12:44
 */

namespace Hetwan\Network\Login\Handler;

use Hetwan\Entity\Account;
use Hetwan\Network\Login\Protocol\Formatter\LoginMessageFormatter;


final class NicknameChoiceHandler extends \Hetwan\Network\Login\Handler\Base\Handler
{
	public function initialize() : void
	{
		$this->send(LoginMessageFormatter::emptyAccountNickname());
	}

	public function handle(string $nickname = null) : bool
	{
		if ($nickname === null or $nickname === 'Af') {
			return false;
		}

		$accounts = $this->entityManager->get()
										->getRepository(Account::class)
										->findByNickname($nickname);

		if (empty($accounts) === false) {
			$this->send(LoginMessageFormatter::notAvailableAccountNickname());
		} else {
			$account = $this->client->getAccount();
			$account->setNickname($nickname);

			$this->client->setHandler(GameServerChoiceHandler::class);
		}

		return true;
	}
}