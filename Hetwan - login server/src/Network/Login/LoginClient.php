<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 21:33:29
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-16 00:27:23
 */

namespace Hetwan\Network\Login;

use App\AppKernel;

use Hetwan\Model\AccountModel;


class LoginClient extends \Hetwan\Network\AbstractClient
{
	/**
	 * @var \Hetwan\Entity\Account
	 */
	protected $account;

	public function __construct(\Ratchet\ConnectionInterface $conn)
	{
		parent::__construct($conn);

		$this->key = \Dofus\Crypto::generateKey(32);

		$this->setHandler('\Hetwan\Network\Login\Handler\VersionHandler');
	}

	public function send($packet)
	{
		$packet = $packet . chr(0);

		AppKernel::getContainer()->get('logger')->debug("({$this->connection->resourceId}) Sending packet: {$packet}\n");

		$this->connection->send($packet);
	}

	public function setAccount(\Hetwan\Entity\Account $account)
	{
		$this->account = $account;
	}

	public function getAccount()
	{
		return $this->account;
	}
}