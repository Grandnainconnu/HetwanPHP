<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-23 17:10:59
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 15:22:18
 */

namespace Hetwan\Network\Game\Handler;

use Hetwan\Network\Handler\HandlerInterface;

use Hetwan\Network\Exchange\ExchangeClient;

use Hetwan\Network\Game\Protocol\Formatter\ApproachMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\AuthentificationMessageFormatter;


class AuthentificationHandler extends AbstractGameHandler
{
	public function initialize()
	{
		$this->send(ApproachMessageFormatter::helloGameMessage());
	}

	public function handle($packet)
	{
		if (substr($packet, 0, 2) != 'AT' || ($ticket = ExchangeClient::getTicket(substr($packet, 2))) == null)
			$this->send(AuthentificationMessageFormatter::badTicketMessage());
		elseif ($this->getClient()->getConnection()->remoteAddress !== $ticket['ipAddress'])
			$this->send(AuthentificationMessageFormatter::authenticationFailedMessage());
		else
		{
			$this->getClient()->setAccount(
				$this->getLoginEntityManager()
					 ->find('\Hetwan\Entity\Login\Account', $ticket['accountId'])
					 ->refresh()
			);

			$this
				->getAccount()
				->setIsOnline(true)
				->save();

			$this->send(AuthentificationMessageFormatter::authenticationSucceedMessage($this->getAccount()->getCommunity()));

			$this->getClient()->setHandler('\Hetwan\Network\Game\Handler\PlayerSelectionHandler');

			return HandlerInterface::COMPLETED;
		}

		return HandlerInterface::FAILED;
	}
}