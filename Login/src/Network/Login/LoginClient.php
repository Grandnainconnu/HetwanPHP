<?php

namespace Hetwan\Network\Login;

use Hetwan\Helper\HashHelper;
use Hetwan\Network\Login\Handler\VersionHandler;


final class LoginClient extends \Hetwan\Network\Base\Client
{
    /**
     * @var string
     */
    public $key;

	/**
	 * @var \Hetwan\Entity\AccountEntity
	 */
	private $account;

	public function initialize() : void
	{
		$this->key = HashHelper::generateKey(32);
	
		$this->setHandler(VersionHandler::class);
	}

	public function send($packet) : void
	{
		$packet .= chr(0);

		$this->logger->debug("({$this->connection->resourceId}) Sending packet: {$packet}\n");
		$this->connection->send($packet);
	}

	public function setAccount(\Hetwan\Entity\AccountEntity $account) : void
	{
		$this->account = $account;
	}

	public function getAccount() : ?\Hetwan\Entity\AccountEntity
	{
		return $this->account;
	}
}