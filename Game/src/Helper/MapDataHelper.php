<?php

namespace Hetwan\Helper;

use Hetwan\Network\Game\Protocol\Enum\ActionTypeEnum;
use Hetwan\Network\Game\Protocol\Formatter\GameMessageFormatter;
use Hetwan\Network\Game\Protocol\Formatter\EnvironementMessageFormatter;


final class MapDataHelper
{
	/**
	 * @Inject
	 * @var \Hetwan\Loader\MapDataLoader
	 */
	private $mapDataLoader;

    /**
     * @Inject
     * @var \Hetwan\Loader\SubAreaDataLoader
     */
    private $subAreaDataLoader;

	/**
	 * @Inject
	 * @var \Hetwan\Helper\Player\PlayerHelper
	 */
	private $playerHelper;

	/**
	 * @Inject
	 * @var \Hetwan\Network\Game\GameServer
	 */
	private $gameServer;

	public function sendToAllPlayers(int $mapId, string $message, array $exceptIds = []) : void
	{
		$clients = $this->gameServer->getClientsPool();

		foreach ($clients as $client) {
			if (($player = $client->getPlayer()) and $player->getMapId() === $mapId and !in_array($player->getId(), $exceptIds)) {
                $client->send($message);
            }
		}
	}

	public function addPlayer(int $mapId, \Hetwan\Entity\Game\PlayerEntity $player) : void
	{
	    if (($map = $this->mapDataLoader->getBy(['id' => $mapId], false, true)) === null) {
	        return;
        }

		$map->addPlayer($player); // Add player in map

		// Add player to all players in map
		$this->sendToAllPlayers($mapId, GameMessageFormatter::showActorsMessage([$player]), [$player->getId()]);

		// Send players in map to current player
		if (($client = $this->playerHelper->getClientWithId($player->getId()))) {
			$client->send(GameMessageFormatter::showActorsMessage($this->getPlayers($mapId)));
		}
	}

	public function movePlayer(int $mapId, \Hetwan\Entity\Game\PlayerEntity $player, string $path) : void
	{
		// Send player movement
		$this->sendToAllPlayers($mapId, GameMessageFormatter::actorMovementMessage($player->getId(), 'a' . HashHelper::cellIdEncode($player->getCellId()) . $path));

		//$player->setAction(ActionTypeEnum::MOVEMENT);
	}

	public function updatePlayerOrientation(int $mapId, \Hetwan\Entity\Game\PlayerEntity $player) : void
	{
		$this->sendToAllPlayers($mapId, EnvironementMessageFormatter::updateActorOrientationMessage($player->getId(), $player->getOrientation()));
	}

	public function removePlayer(int $mapId, \Hetwan\Entity\Game\PLayerEntity $player) : void
	{
        if (($map = $this->mapDataLoader->getBy(['id' => $mapId], false, true)) === null) {
            return;
        }

        $map->removePlayer($player);

		$this->sendToAllPlayers($mapId, GameMessageFormatter::removeActorsMessage([$player->getId()]));
	}

	public function teleportPlayer(\Hetwan\Entity\Game\MapDataEntity $mapData, int $cellId, \Hetwan\Network\Game\GameClient $client) : void
	{
		$this->removePlayer($client->getPlayer()->getMapId(), $client->getPlayer());

		$client->getPlayer()->setMapId($mapData->getId())
                            ->setCellId($cellId);

        $client->send(GameMessageFormatter::mapDataMessage($mapData->getId(), $mapData->getDate(), $mapData->getKey()));
	}

	public function getPlayers(int $mapId) : array
	{
	    $players = [];

		if (($map = $this->mapDataLoader->getBy(['id' => $mapId], false, true)) !== null) {
			$players = $map->getPlayers();
		}

		return $players;
	}

    public function getAreaId(int $mapId) : ?int
    {
        if (($map = $map = $this->mapDataLoader->getBy(['id' => $mapId], false, true)) === null) {
            return null;
        }

        $subAreaId = $map->getSubAreaId();
        $subArea = $this->subAreaDataLoader->getBy(['id' => $subAreaId], false, true);

        return $subArea->getAreaId();
    }
}