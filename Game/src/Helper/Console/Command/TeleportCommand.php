<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-23 17:59:47
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-27 01:06:17
 */

namespace Hetwan\Helper\Console\Command;

use Hetwan\Helper\Console\Command\Base\CommandArgument;


final class TeleportCommand extends \Hetwan\Helper\Console\Command\Base\Command
{
	/**
	 * @Inject
	 * @var \Hetwan\Helper\MapDataHelper
	 */
	private $mapDataHelper;

	/**
	 * @Inject
	 * @var \Hetwan\Helper\Player\PlayerHelper
	 */
	private $playerHelper;

	/**
	 * @Inject
	 * @var \Hetwan\Loader\MapDataLoader
	 */
	private $mapDataLoader;

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

	public function execute(array $arguments, int $playerId)
	{
		$playersTeleported = [];

		$mapData = $this->mapDataLoader->getBy(['id' => $arguments[0]], false, true);

		if ($mapData === null) {
            return $this->errorMessage('Map ' . $arguments[0] . ' doesn\'t exists');
        }

		$players = (!isset($arguments[2]) ? [$playerId] : $arguments[2]);

		foreach ($players as $playerId) {
			if (($client = $this->playerHelper->getClientWithId($playerId)) !== null) {
				$this->mapDataHelper->teleportPlayer($mapData, $arguments[1], $client);

				$playersTeleported[] = $playerId;
			}
		}
		
		unset($players);

		if (empty($playersTeleported)) {
			return $this->errorMessage('Unable to teleport any players.');
		}

		return $this->successMessage('Player(s) [' . implode(', ', $playersTeleported) . '] successfully teleported.');
	}
}