<?php

namespace Hetwan\Network\Game\Handler;

use Hetwan\Helper\ScriptedCellDataHelper;
use Hetwan\Helper\Player\Interaction\MovementInteractionHelper;
use Hetwan\Network\Game\Base\Handler\HandlerTrait;
use Hetwan\Network\Game\Protocol\Enum\ActionTypeEnum;
use Hetwan\Network\Game\Protocol\Formatter\GameMessageFormatter;


class GameHandler extends \Hetwan\Network\Base\Handler\Handler
{
    /**
     * @Inject
     * @var \DI\Container
     */
    private $container;

    /**
     * @Inject
     * @var \Hetwan\Helper\ExperienceDataHelper
     */
    private $experienceDataHelper;

    /**
     * @Inject
     * @var \Hetwan\Helper\MapDataHelper
     */
    private $mapDataHelper;

    /**
     * @Inject
     * @var \Hetwan\Loader\MapDataLoader
     */
    private $mapDataLoader;

    /**
     * @Inject
     * @var \Hetwan\Loader\ScriptedCellDataLoader
     */
    private $scriptedCellDataLoader;

	use HandlerTrait;

	public function handle(string $data) : bool
	{
		switch ($data[0]) {
			case 'A':
				$this->startGameAction(ActionTypeEnum::toString((int)substr($data, 1, 4)), substr($data, 4));

				break;
			case 'C':
				$this->playerLoaded();

				break;
			case 'I':
				$this->playerSpawn();

				break;
			case 'K':
				$this->endGameAction(substr($data, 1, 1) == 'K', substr($data, 2));

				break;
			default:
                $this->logger->debug('Unable to handle game packet: ' . $data . PHP_EOL);

				break;
		}

		return true;
	}

    /**
     * When the player is loaded
     * @return void
     */
	private function playerLoaded() : void
	{
		$this->send(GameMessageFormatter::playerLoadedMessage($this->getPlayer()->getName(), true));
		$this->send(GameMessageFormatter::playerStatisticsMessage(
		    $this->getPlayer(),
            $this->experienceDataHelper->getWithLevel($this->getPlayer()->getLevel()))
        );
		$this->send(GameMessageFormatter::playerRegenerationIntervalMessage(2000));

		if (($mapData = $this->mapDataLoader->getBy(['id' => $this->getPlayer()->getMapId()], false, true)) === null) {
            return;
        }

		$this->send(GameMessageFormatter::mapDataMessage(
			$mapData->getId(), 
			$mapData->getDate(),
			$mapData->getKey()
		));
	}

    /**
     * When a player is ready to spawn
     * @return void
     */
	private function playerSpawn() : void
	{
		$this->mapDataHelper->addPlayer($this->getPlayer()->getMapId(), $this->getPlayer());

		$this->send(GameMessageFormatter::mapLoadedMessage());
		$this->send(GameMessageFormatter::mapFightCountMessage(0));
	}

    /**
     * Handle game action
     * @param string $actionType
     * @param string $path
     */
	private function startGameAction(string $actionType, string $path) : void
    {
		switch (ActionTypeEnum::fromString($actionType)) {
            case 0:
			case ActionTypeEnum::MOVEMENT:
				$this->client->addInteraction(($this->container->make(MovementInteractionHelper::class, ['player' => $this->client->getPlayer(), 'path' => $path])))->begin();

				break;
		}
	}

    /**
     * Handle game action end
     * @param bool $actionSucceed
     * @param string $packet
     */
	private function endGameAction(bool $actionSucceed, string $packet) : void
	{
		$interaction = $this->client->removeInteraction();

		switch ($interaction->getType()) {
			case ActionTypeEnum::MOVEMENT:
				if ($actionSucceed) {
					$interaction->end();

					if (($scriptedCell = $this->scriptedCellDataLoader->getBy(['mapId' => $this->getPlayer()->getMapId(), 'cellId' => $this->getPlayer()->getCellId()], false, true)) !== null) {
                        list($nextMapId, $nextCellId) = ScriptedCellDataHelper::use($scriptedCell);

						if (($mapData = $this->mapDataLoader->getBy(['id' => $nextMapId], false, true)) === null) {
                            return;
                        }

						$this->mapDataHelper->teleportPlayer($mapData, $nextCellId, $this->client);
					}
				} else {
                    list($orientation, $cellId) = explode('|', $packet);

					$interaction->cancel((int)$orientation, (int)$cellId);
				}

				break;
			default:
				if ($actionSucceed) {
                    $interaction->end();
                } else {
                    $interaction->cancel();
                }

				break;
		}
	}
}