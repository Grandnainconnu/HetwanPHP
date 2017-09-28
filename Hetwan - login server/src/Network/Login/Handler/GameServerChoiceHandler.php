<?php

/**
 * @Author: jean
 * @Date:   2017-09-07 13:05:15
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-18 14:51:52
 */

namespace Hetwan\Network\Login\Handler;

use Hetwan\Network\Handler\HandlerInterface;

use Hetwan\Network\Login\Protocol\Formatter\LoginMessageFormatter;

use Hetwan\Network\Login\Protocol\Enum\ServerStates;
use Hetwan\Network\Login\Protocol\Enum\ServerPopulations;


final class GameServerChoiceHandler extends AbstractLoginHandler
{
	public function initialize()
	{
		$this->send(LoginMessageFormatter::accountNicknameInformationMessage($this->getAccount()->getNickname()));
		$this->send(LoginMessageFormatter::accountCommunityInformationMessage($this->getAccount()->getCommunity()));
		$this->refreshServersList();
		$this->send(LoginMessageFormatter::identificationSuccessMessage($this->getAccount()->getGmLevel() > 0 ? 1 : 0));
		$this->send(LoginMessageFormatter::accountSecretQuestionInformationMessage($this->getAccount()->getSecretQuestion()));
	}

	public function refreshServersList()
	{
		$this->send(LoginMessageFormatter::serversListMessage(\Hetwan\Loader\ServerLoader::getServers()));
	}

	private function searchPlayersByAccountNickname($nickname)
	{
		$account = $this->getEntityManager()
						->getRepository('\Hetwan\Entity\Account')
						->findOneByNickname($nickname);

		$this->send(LoginMessageFormatter::searchPlayersMessage($account != null
			?
				$account->getPlayers()
			:
				[]
		));
	}

	private function generateTicket($serverId)
	{
		$ticketKey = uniqid();

		$server = \Hetwan\Network\Exchange\ExchangeServer::getServerWithId($serverId);
		
		preg_match('/^(.*?):\/\/(.*?):(.*)/', $this->getClient()->getConnection()->remoteAddress, $matches); // parsing URI from Ratchet

		$server->sendTicket($ticketKey, $matches[2], $this->getAccount()->getId());

		return $ticketKey;
	}

	private function sendAccessServerResponse($id)
	{
		if (null == ($server = \Hetwan\Loader\ServerLoader::findById($id)) || $server->getState() != ServerStates::ONLINE)
			$this->send(LoginMessageFormatter::serverInaccessible());
		elseif ($server->getRequireSubscription() == true && !$this->getAccount()->getSubscriptionTimeLeft())
			$this->send(LoginMessageFormatter::serverRequireSubscription());
		elseif ($server->getPopulation() == ServerPopulations::FULL)
			$this->send(LoginMessageFormatter::serverFull());
		else
			$this->send(LoginMessageFormatter::serverAccess($server->getIpAddress(), $server->getPort(), $this->generateTicket($server->getId())));
	}

	public function handle($data)
	{
		switch (substr($data, 1, 1))
		{
			case 'f':
				// TODO: queue
				$this->send(LoginMessageFormatter::queueMessage(1, 0, 0, 1));

				break;
			case 'F':
				$this->searchPlayersByAccountNickname(substr($data, 2));

				break;
			case 'x':
				$this->send(LoginMessageFormatter::playersListMessage($this->getAccount()));

				break;
			case 'X':
				$this->sendAccessServerResponse(substr($data, 2));

				break;
		}
	}
}