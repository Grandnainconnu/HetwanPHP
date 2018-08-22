<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 21:33:29
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-11-01 22:29:47
 */

namespace Hetwan\Network\Game;

use App\AppKernel;

use Hetwan\Model\AccountModel;


class GameClient extends \Hetwan\Network\AbstractClient
{
	/**
	 * @var \Hetwan\Entity\Account
	 */
	protected $account;

	/**
	 * @var \Hetwan\Entity\Player
	 */
	protected $player;

	/**
	 * @var array
	 */
	protected $interactions = [];

	/**
	 * Client key
	 *
	 * @var string
	 */
	protected $key;

	public function __construct(\Ratchet\ConnectionInterface $conn)
	{
		parent::__construct($conn);

		$this->setHandler('\Hetwan\Network\Game\Handler\AuthentificationHandler');
	}

	public function send($packet)
	{
		$packet = $packet . chr(0);

		AppKernel::getContainer()->get('logger')->debug("({$this->connection->resourceId}) Sending packet: {$packet}\n");

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

	public function setAccount(\Hetwan\Entity\Login\Account $account)
	{
		$this->account = $account;
	}

	public function getAccount()
	{
		return $this->account;
	}

	public function setPlayer(\Hetwan\Entity\Login\Player $player)
	{
		$this->player = $player;
	}

	public function getPlayer()
	{
		return $this->player;
	}

	public function setKey($key)
	{
		$this->key = $key;
	}

	public function getKey()
	{
		return $this->key;
	}
}