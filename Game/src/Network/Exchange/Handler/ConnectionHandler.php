<?php

/**
 * @Author: jean
 * @Date:   2017-09-15 13:13:28
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 12:52:20
 */

namespace Hetwan\Network\Exchange\Handler;

use Hetwan\Network\Exchange\Protocol\Enum\ServerState;


final class ConnectionHandler extends \Hetwan\Network\Base\Handler\Handler
{
	/**
	 * @Inject
	 * @var \Hetwan\Helper\AccountHelper
	 */
	private $accountHelper;

    /**
     * @Inject
     * @var \Hetwan\Network\Game\GameServer
     */
    private $gameServer;

	public function initialize() : void
	{
		$this->client->setServerState(ServerState::ONLINE);
	}

	public function handle(string $data) : bool
	{
		switch ($data[0]) {
			case 'A': // Force disconnect account
				if (substr($data, 0, 2) !== 'Ad') {
					return false;
				}

				$accountId = substr($data, 2);
				$client = $this->accountHelper->getClientWithId($accountId);

				if ($client !== null) {
					$this->gameServer->removeClient($client->getConnection());
					$client->getConnection()->close();
				}

				break;
			case 'T': // Account ticket
				list($ticketId, $ipAddress, $accountId) = explode('|', substr($data, 1));

				$this->client->addTicket($ticketId, $ipAddress, $accountId);

				break;
		}

		return true;
	}
}