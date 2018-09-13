<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-23 17:10:59
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 15:22:18
 */

namespace Hetwan\Network\Game\Handler;

use Hetwan\Entity\Game\ItemEntity;
use Hetwan\Entity\Login\AccountEntity;
use Hetwan\Network\Game\Base\Handler\HandlerTrait;
use Hetwan\Network\Game\Protocol\Formatter\{ApproachMessageFormatter, AuthentificationMessageFormatter};


class AuthentificationHandler extends \Hetwan\Network\Base\Handler\Handler
{
	use HandlerTrait;

	/**
	 * @Inject
	 * @var \Hetwan\Network\Exchange\ExchangeConnection
	 */
	private $exchangeConnection;

	public function initialize() : void
	{
		$this->send(ApproachMessageFormatter::helloGameMessage());
	}

	public function handle(string $packet) : bool
	{
		if (substr($packet, 0, 2) !== 'AT' or
            ($this->exchangeConnection->isAlive() and ($ticket = $this->exchangeConnection->getClient()->getTicket(substr($packet, 2))) === null)
        ) {
			$this->send(AuthentificationMessageFormatter::badTicketMessage());
		} elseif ($this->client->getConnection()->remoteAddress !== $ticket['ipAddress']) {
			$this->send(AuthentificationMessageFormatter::authenticationFailedMessage());
		} else {
			$this->client->setAccount(
			    $this->entityManager->get('login')
									->find(AccountEntity::class, $ticket['accountId'])
			);

			$this->onAccountLoaded();

			$this->send(AuthentificationMessageFormatter::authenticationSucceedMessage($this->getAccount()->getCommunity()));

			$this->client->setHandler(PlayerSelectionHandler::class);

			return true;
		}

		return false;
	}

	private function onAccountLoaded() : void
    {
        $this->entityManager->refresh($this->getAccount(), 'login')->setIsOnline(true);
    }
}