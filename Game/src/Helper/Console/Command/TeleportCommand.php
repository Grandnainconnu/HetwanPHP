<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-23 17:59:47
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-27 01:06:17
 */

namespace Hetwan\Helper\Console\Command;

use Hetwan\Helper\Player\PlayerHelper;

use Hetwan\Loader\MapDataLoader;


class TeleportCommand extends AbstractCommand
{
	public function __construct()
	{
		$this->name = 'teleport';
		$this->description = 'Teleport targeted player(s).';
		$this->arguments = [
			new CommandArgument('mapId', 'ID of the targeted map', CommandArgument::INTEGER),
			new CommandArgument('cellId', 'ID of the targeted cell', CommandArgument::INTEGER),
			new CommandArgument('players', 'Targeted players (separated by a comma)', CommandArgument::STRING, CommandArgument::FILTER_COMMA, false)
		];
	}

	public function execute($arguments, $playerId)
	{
		$playersTeleported = [];

		if (($mapData = MapDataLoader::getMapWithId($arguments[0])) == null)
			return $this->errorMessage(sprintf("Map '%d' doesn't exists", $arguments[0]));

		foreach ((!isset($arguments[2]) ? [$playerId] : $arguments[2]) as $playerId)
			if (($clientId = \Hetwan\Network\Game\GameServer::getClientWithPlayer($playerId)) != null)
			{
				PlayerHelper::teleport($clientId, $mapData, $arguments[1]);

				$playersTeleported[] = $playerId;
			}

		if (empty($playersTeleported))
			return $this->errorMessage('Unable to teleport any players.');

		return $this->successMessage(sprintf('Player(s) [%s] successfully teleported.', implode(', ', $playersTeleported)));
	}
}