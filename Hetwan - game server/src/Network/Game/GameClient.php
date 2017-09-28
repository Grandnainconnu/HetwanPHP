<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 21:33:29
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 21:38:42
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
	 * Client key
	 * @var string
	 */
	protected $key;

	public function __construct(\Ratchet\ConnectionInterface $conn)
	{
		parent::__construct($conn);

		$this->setHandler('\Hetwan\Network\Game\Handler\AccountHandler');
	}

	public function send($packet)
	{
		$packet = $packet . chr(0);

		AppKernel::getContainer()->get('logger')->debug("({$this->connection->resourceId}) Sending packet: {$packet}\n");

		$this->connection->send($packet);
	}

	public function setAccount(\Hetwan\Entity\Login\Account $account)
	{
		$this->account = $account;
	}

	public function getAccount()
	{
		return $this->account;
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