<?php

/**
 * @Author: jeanw
 * @Date:   2017-11-01 21:50:13
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-11-01 22:24:15
 */

namespace Hetwan\Helper\Player\Interaction;

use Hetwan\Util\Cryptography;

use Hetwan\Helper\MapDataHelper;

use Hetwan\Network\Game\GameClient;
use Hetwan\Network\Game\Protocol\Enum\ActionTypeEnum;


class MovementInteractionHelper
{
	private $client,
			$path;

	public function __construct(GameClient $client, $path)
	{
		$this->client = $client;
		$this->path = $path;
	}

	public function getType()
	{
		return ActionTypeEnum::MOVEMENT;
	}

	public function begin()
	{
		MapDataHelper::movePlayerInMap(
			(int) $this->client->getPlayer()->getMapId(), 
			$this->client->getPlayer(),
			$this->path
		);
	}

	public function cancel($orientation, $cellId)
	{
		// Update player to final position
		$this->client->getPlayer()->setCellId($cellId);
		$this->client->getPlayer()->setOrientation($orientation);
	}

	public function end()
	{
		// Update player to final position
		$this->client->getPlayer()->setCellId(Cryptography::cellIdDecode(substr($this->path, -2)));
		$this->client->getPlayer()->setOrientation(ord(substr($this->path, -3, 1)) - ord('a'));
	}
}