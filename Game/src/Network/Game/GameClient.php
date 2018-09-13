<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 21:33:29
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-11-01 22:29:47
 */

namespace Hetwan\Network\Game;

use Hetwan\Network\Game\Handler\AuthentificationHandler;
use Hetwan\Model\AccountModel;


class GameClient extends \Hetwan\Network\Base\Client
{
	/**
	 * @var array
	 */
	protected $interactions = [];

	/**
	 * @var \Hetwan\Entity\Login\AccountEntity
	 */
	protected $account;

	/**
	 * @var \Hetwan\Entity\Game\PlayerEntity
	 */
	protected $player;

	/**
	 * Client key
	 *
	 * @var string
	 */
	protected $key;

	public function initialize(): void
	{
		$this->setHandler(AuthentificationHandler::class);
	}

	public function send($packet) : void
	{
		$packet .= chr(0);

		$this->logger->debug("({$this->connection->resourceId}) Sending packet: {$packet}\n");

		$this->connection->send($packet);
	}

	public function addInteraction($interaction)
	{
		$this->interactions[] = $interaction;

		return $interaction;
	}

	public function removeInteraction()
	{
		// Reset interactions keys
		$this->interactions = array_values($this->interactions);

		$interaction = $this->interactions[($index = count($this->interactions) - 1)];

		unset($this->interactions[$index]);

		return $interaction;
	}

	public function setAccount(\Hetwan\Entity\Login\AccountEntity $account) : \Hetwan\Network\Game\GameClient
	{
		$this->account = $account;

		return $this;
	}

	public function setPlayer(\Hetwan\Entity\Game\PlayerEntity $player) : \Hetwan\Network\Game\GameClient
	{
		$this->player = $player;

		return $this;
	}

	public function setKey(string $key) : \Hetwan\Network\Game\GameClient
	{
		$this->key = $key;

		return $this;
	}

	public function getAccount() : ?\Hetwan\Entity\Login\AccountEntity
	{
		return $this->account;
	}

	public function getPlayer() : ?\Hetwan\Entity\Game\PlayerEntity
	{
		return $this->player;
	}

	public function getKey() : ?string
	{
		return $this->key;
	}
}