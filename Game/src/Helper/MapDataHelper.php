<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-27 18:09:38
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-31 14:09:04
 */

namespace Hetwan\Helper;

use Hetwan\Network\Game\GameServer;

use Hetwan\Util\Cryptography;

use Hetwan\Loader\MapDataLoader;

use Hetwan\Network\Game\Protocol\Formatter\GameMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\ItemMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\EnvironementMessageFormatter;


class MapDataHelper extends AbstractHelper
{
	public static function getAreaIdWithMapId(int $mapId)
	{
		$subAreaId = MapDataLoader::getMapWithId($mapId)->getSubAreaId();
		$subArea = self::getGameEntityManager()
						->getRepository('\Hetwan\Entity\Game\SubAreaData')
						->findOneById($subAreaId);

		return ($subArea->getAreaId());
	}

	public static function addPlayerInMap(int $mapId, $player)
	{
		MapDataLoader::addPlayerInMap($mapId, $player); // Add player to map

		// Add player to all players in map
		GameServer::sendToAllPlayersInMap(
			$mapId,
			GameMessageFormatter::showActorsMessage([$player]),
			[$player->getId()]
		);

		// Send players in map to current player
		GameServer::getClientWithPlayer($player->getId())->send(
			GameMessageFormatter::showActorsMessage(\Hetwan\Loader\MapDataLoader::getPlayersInMap($mapId))
		);
	}

	public static function updatePlayerAccessoriesInMap($player)
	{
		// Update player accessories for all players in map
		GameServer::sendToAllPlayersInMap(
			$player->getMapId(),
			ItemMessageFormatter::accessoriesMessage($player),
			[]
		);
	}

	public static function movePlayerInMap(int $mapId, $player, string $path)
	{
		// Send player movement
		GameServer::sendToAllPlayersInMap(
			$mapId,
			GameMessageFormatter::actorMovementMessage($player->getId(), 'a' . Cryptography::cellIdEncode($player->getCellId()) . $path)
		);

		$player->setAction(\Hetwan\Network\Game\Protocol\Enum\ActionTypeEnum::MOVEMENT);
	}

	public static function updatePlayerOrientationInMap(int $mapId, $player)
	{
		GameServer::sendToAllPlayersInMap(
			$mapId,
			EnvironementMessageFormatter::updateActorOrientationMessage($player->getId(), $player->getOrientation())
		);
	}

	public static function removePlayerInMap(int $mapId, $player)
	{
		MapDataLoader::removePlayerInMap($mapId, $player);

		GameServer::sendToAllPlayersInMap(
        	$mapId,
        	GameMessageFormatter::removeActorsMessage([$player->getId()])
        );
	}
}