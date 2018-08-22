<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 21:33:29
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 22:14:01
 */

namespace Hetwan\Network\Login;

use Hetwan\Helper\Hash;
use Hetwan\Entity\Account;
use Hetwan\Network\Login\Handler\VersionHandler;


final class LoginClient extends \Hetwan\Network\Base\Client
{
    /**
     * @var string
     */
    public $key;

	/**
	 * @var \Hetwan\Entity\Account
	 */
	private $account;

	public function initialize() : void
	{
		$this->key = Hash::generateKey(32);
		$this->setHandler(VersionHandler::class);
	}

	public function send($packet) : void
	{
		$packet = $packet . chr(0);

		$this->logger->debug("({$this->connection->resourceId}) Sending packet: {$packet}\n");
		$this->connection->send($packet);
	}

	public function setAccount(\Hetwan\Entity\Account $account) : void
	{
		$this->account = $account;
	}

	public function getAccount() : ?\Hetwan\Entity\Account
	{
		return $this->account;
	}
}