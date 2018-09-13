<?php

namespace Hetwan\Network\Login\Handler;

use Hetwan\Entity\AccountEntity;
use Hetwan\Helper\HashHelper;
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
	 * @var \Hetwan\Helper\AccountHelper
	 */
	private $accountHelper;

	public function handle(string $packet) : bool
	{
		if (strpos($packet, '#1') === false) {
			$this->send(LoginMessageFormatter::badPacketMessage());

			return false;
		}

		list($username, $password) = explode('#', $packet);

		$account = $this->entityManager->get()
								   	   ->getRepository(AccountEntity::class)
								   	   ->findOneByUsername($username);

		if (!$account or HashHelper::encryptValue($account->getPassword(), $this->client->key) !== $password) {
			$this->send(LoginMessageFormatter::identificationFailedMessage());
		} else {
			$this->entityManager->get()
								->refresh($account);

			if (($ban = $account->getIsBanned()) !== null) {
				$this->send(LoginMessageFormatter::accountBannedMessage($ban->getEndDate()));
			} elseif ($this->accountHelper->getClientWithId($account->getId()) !== null) {
				$this->send(LoginMessageFormatter::accountAlreadyConnectedMessage());
			} elseif ($account->getIsOnline() === true) {
				$clientsPool = $this->exchangeServer->getClientsPool();

				foreach ($clientsPool as $server) {
					$server->send(ExchangeMessageFormatter::accountDisconnectMessage($account->getId()));
				}

				unset($clientsPool);

				$this->send(LoginMessageFormatter::accountAlreadyConnectedOnGameServerMessage());
			} else {
				$this->client->setAccount(
				    $this->entityManager->refresh($account)
                );

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