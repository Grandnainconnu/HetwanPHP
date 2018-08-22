<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 19:16:59
 * @Last Modified by:   Jean Walrave
 * @Last Modified time: 2018-04-11 14:11:10
 */

namespace Hetwan\Network\Login\Handler;

use Hetwan\Entity\Account;
use Hetwan\Helper\Hash;
use Hetwan\Network\Login\Protocol\Formatter\LoginMessageFormatter;
use Hetwan\Network\Exchange\Protocol\Formatter\ExchangeMessageFormatter;


final class AuthentificationHandler extends \Hetwan\Network\Login\Handler\Base\Handler
{
	/**
	 * @Inject
	 * @var \Hetwan\Network\Exchange\ExchangeServer
	 */
	private $exchangeServer;

	/**
	 * @Inject
	 * @var \Hetwan\Network\Login\LoginServer
	 */
	private $loginServer;

	public function handle(string $packet) : bool
	{
		if (strpos($packet, '#1') === false) {
			$this->send(LoginMessageFormatter::badPacketMessage());

			return false;
		}

		list($username, $password) = explode('#', $packet);

		$account = $this->entityManager->get()
								   	   ->getRepository(Account::class)
								   	   ->findOneByUsername($username);

		if (!$account or Hash::encryptValue($account->getPassword(), $this->client->key) !== $password) {
			$this->send(LoginMessageFormatter::identificationFailedMessage());
		} else {
			$this->entityManager->get()
								->refresh($account);

			if (($ban = $account->getIsBanned()) !== null) {
				$this->send(LoginMessageFormatter::accountBannedMessage($ban->getEndDate()));
			} elseif ($this->loginServer->getClientWithAccount($account->getId()) !== null) {
				$this->send(LoginMessageFormatter::accountAlreadyConnectedMessage());
			} elseif ($account->getIsOnline() === true) {
				$clientsPool = $this->exchangeServer->getClientsPool();

				foreach ($clientsPool as $server) {
					$server->send(ExchangeMessageFormatter::accountDisconnectMessage($account->getId()));
				}

				unset($clientsPool);

				$this->send(LoginMessageFormatter::accountAlreadyConnectedOnGameServerMessage());
			} else {
				$this->client->setAccount($account);

				if ($account->getNickname() === null) {
					$this->client->setHandler(NicknameChoiceHandler::class);
				} else {
					$this->client->setHandler(GameServerChoiceHandler::class);
				}

				return true;
			}
		}

		return false;
	}
}