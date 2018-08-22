<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-26 23:02:17
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-23 16:24:35
 */

namespace Hetwan\Network\Game\Handler;

use Hetwan\Helper\MapDataHelper;
use Hetwan\Helper\ScriptedCellDataHelper;
use Hetwan\Helper\Player\PlayerHelper;
use Hetwan\Helper\Player\Interaction\MovementInteractionHelper;

use Hetwan\Loader\MapDataLoader;

use Hetwan\Network\Game\Protocol\Enum\ActionTypeEnum;

use Hetwan\Network\Game\Protocol\Formatter\GameMessageFormatter;


class GameHandler extends AbstractGameHandler
{
	public function handle($data)
	{
		switch (substr($data, 0, 1))
		{
			case 'A':
				$this->gameAction(ActionTypeEnum::toString((int) substr($data, 1, 4)), substr($data, 4));				

				break;
			case 'C':
				$this->playerLoaded();

				break;
			case 'I':
				$this->playerSpawn();

				break;
			case 'K':
				$this->gameActionEnd(substr($data, 1, 1) == 'K', substr($data, 2));

				break;
			default:
				echo "Unable to handle game action packet: {$data}\n";

				break;
		}
	}

	private function playerLoaded()
	{
		$this->send(GameMessageFormatter::playerLoadedMessage($this->getPlayer()->getName(), true));
		$this->send(GameMessageFormatter::playerStatisticsMessage($this->getPlayer()));
		$this->send(GameMessageFormatter::playerRegenerationIntervalMessage(2000));

		if (($mapData = MapDataLoader::getMapWithId((int) $this->getPlayer()->getMapId())) == null)
			return;

		$this->send(GameMessageFormatter::mapDataMessage(
			$mapData->getId(), 
			$mapData->getDate(),
			$mapData->getKey()
		));
	}

	private function playerSpawn()
	{
		MapDataHelper::addPlayerInMap((int) $this->getPlayer()->getMapId(), $this->getPlayer());

		$this->send(GameMessageFormatter::mapLoadedMessage());
		$this->send(GameMessageFormatter::mapFightCountMessage(0));
	}

	private function gameAction($actionType, $path)
	{
		switch (ActionTypeEnum::fromString($actionType))
		{
			case ActionTypeEnum::MOVEMENT:
				$this->getClient()->addInteraction((new MovementInteractionHelper($this->getClient(), $path)))->begin();

				break;
		}
	}

	private function gameActionEnd($actionSucceed, $packet)
	{
		$interaction = $this->getClient()->removeInteraction();

		switch ($interaction->getType())
		{
			case ActionTypeEnum::MOVEMENT:
				if ($actionSucceed)
				{
					$interaction->end();

					if (($scriptedCell = ScriptedCellDataHelper::getScriptedCell($this->getPlayer()->getMapId(), $this->getPlayer()->getCellId())) != null)
					{
						$nextMapInformations = ScriptedCellDataHelper::useScriptedCell($scriptedCell);

						if (($mapData = MapDataLoader::getMapWithId((int) $nextMapInformations['nextMapId'])) == null)
							return;

						PlayerHelper::teleport($this->getClient(), $mapData, $nextMapInformations['nextCellId']);
					}
				}
				else
				{
					$spltdPacket = explode('|', $packet);

					$interaction->cancel($spltdPacket[0], $spltdPacket[1]);
				}

				break;
			default:
				if ($actionSucceed)
					$interaction->end();
				else
					$interaction->cancel();

				break;
		}
	}
}