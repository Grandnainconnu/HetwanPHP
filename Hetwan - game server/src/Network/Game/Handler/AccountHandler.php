<?php

/**
 * @Author: jean
 * @Date:   2017-09-07 13:03:54
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-24 15:07:01
 */

namespace Hetwan\Network\Game\Handler;

use Hetwan\Network\Handler\HandlerInterface;

use Hetwan\Network\Exchange\ExchangeClient;

use Hetwan\Network\Game\Protocol\Formatter\GameMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\AccountMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\PlayerMessageFormatter;


class AccountHandler extends AbstractGameHandler
{
	public function initialize()
	{
		$this->send(GameMessageFormatter::helloConnectMessage());
	}

	public function handle($data)
	{
		switch (substr($data, 1, 1))
		{
			case 'A':
				$this->createPlayer($data);

				break;
			case 'D':
				$this->deletePlayer($data);

				break;
			case 'f':
				$this->send(GameMessageFormatter::queueMessage(1, 0, 0, 1));

				break;
			case 'i':
				$this->getClient()->setKey(substr($data, 2));

				break;
			case 'L':
				$this->playersListMessage();

				break;
			case 'P':
				$this->send(PlayerMessageFormatter::generatedPlayerNameMessage(\Dofus\NameGenerator::generate()));

				break;
			case 'S':
				$account = $this->getAccount();

				$id = substr($data, 2);
				$player = $this->getLoginEntityManager()->find('\Hetwan\Entity\Login\Player', $id);

				$this->send('Rx0');
				$this->send('ASK|'. $id . '|' . $player->getName() . '|' . $player->getLevel() . '||' . $player->getGender() . '|' . $player->getSkinId() . '|' . $player->getColors() . '|');
				$this->send('Im189');
				$this->send('Af1|1|0|1|1');
				$this->send('GCK|1|'. $player->getName());
				$this->send('GDM|7411|0711291819|556a5867706b7f7f694d754537565e7d437357343b49337d7a455d3c722a4974415445242e654c277c542f246f7764593831672c3f65227725324274565c692532422f2e3e2f726934556c512e387f4e75447b3e475b2972642c64685a33374b2a555d4c5f4f435c612d64566c2e2e38695248205b4c5c5a4c6242512947213536747d5f522d582d366b26647d2d73576a6b487b5f574a225a3440543a405a517551522d622a403d4a486477675646725f3367677c7d2934657f32663e46634064233d48677f3b524b2c352f402922744167333f7c5d7076674f43');
				$this->send('GM|+250;0;0;' . $player->getId() .';' . $player->getName() . ';' . $player->getBreed() . ';' . $player->getSkinId() . '^100;' . $player->getGender() . ';-1;' . $player->getColors() . ';;-1;;;;;0;;');
				$this->send('GDK');
				break;
			case 'T':
				return $this->ticketAuthentification($data);

				break;
			case 'V':
				$this->send(AccountMessageFormatter::requestRegionalVersionMessage(0));

				break;
		}
	}

	private function ticketAuthentification($packet)
	{
		if (($ticket = ExchangeClient::getTicket(substr($packet, 2))) == null)
			$this->send(AccountMessageFormatter::invalidTicketMessage());
		elseif (!strpos($this->getClient()->getConnection()->remoteAddress, $ticket['ipAddress']))
			$this->send(AccountMessageFormatter::authenticationFailedMessage());
		else
		{
			$this->send(AccountMessageFormatter::authenticationSucceedMessage(0));

			$this->getClient()->setAccount(
				$this->getLoginEntityManager()
					 ->find('\Hetwan\Entity\Login\Account', $ticket['accountId'])
					 ->refresh()
			);

			return HandlerInterface::COMPLETED;
		}

		return HandlerInterface::FAILED;
	}

	private function createPlayer($packet)
	{
		$packet = explode('|', substr($packet, 2));

		if ($this->getAccount()->getPlayers()->count() == $this->getAccount()->getMaxPlayers())
			$this->send(PlayerMessageFormatter::maxPlayersReachedMessage());
		elseif (!(strlen($packet[0]) >= 2 && strlen($packet[0]) <= 20) || !preg_match('/^[a-zA-Z-]/', $packet[0]))
			$this->send(PlayerMessageFormatter::invalidPlayerNameMessage());
		elseif ($this->getLoginEntityManager()->getRepository('\Hetwan\Entity\Login\Player')->countByNameCaseInsensitive($packet[0]) > 0)
			$this->send(PlayerMessageFormatter::playerNameAlreadyTakenMessage());
		else
		{
			$player = new \Hetwan\Entity\Login\Player();
			$this->getAccount()->addPlayer(
				$player->setName($packet[0])
					   ->setBreed($packet[1])
					   ->setGender($packet[2])
					   ->setColors($packet[3] . ';' . $packet[4] . ';' . $packet[5])
					   ->setLevel(1)
					   ->setSkinId($packet[1] . $packet[2])
					   ->setServerId($this->getContainer()->get('configuration')->get('server.id'))
					   ->setAccount($this->getAccount())
					   ->setAccessories(\Hetwan\Helper\PlayerHelper::makeAccessories($player))
					   ->save()
			)->save();

			$this->send(PlayerMessageFormatter::playerCreatedMessage());
			$this->playersListMessage();
		}
	}

	private function deletePlayer($packet)
	{
		$packet = explode('|', substr($packet, 2));

		if ((!$packet[1] || $packet[1] == $this->getAccount()->getSecretAnswer()) && null != ($player = \Hetwan\Helper\AccountHelper::hasPlayer($this->getAccount()->getPlayers(), $packet[0], true)))
		{
			$player->remove();
			$this->playersListMessage();
		}
		else
			$this->send(PlayerMessageFormatter::playerDeleteFailedMessage());
	}

	private function playersListMessage()
	{
		$this->send(PlayerMessageFormatter::playersListMessage(
			$this->getAccount(), 
			$this->getContainer()->get('configuration')->get('server.id')
		));
	}
}