<?php

namespace Hetwan\Network\Game\Handler;

use Hetwan\Entity\Game\PlayerEntity;
use Hetwan\Helper\Player\Breed\BreedHelper;
use Hetwan\Helper\Player\PlayerHelper;
use Hetwan\Network\Game\Base\Handler\HandlerTrait;
use Hetwan\Network\Game\Protocol\Formatter\{
    GameMessageFormatter,
    ApproachMessageFormatter,
    PlayerMessageFormatter
};


class PlayerSelectionHandler extends \Hetwan\Network\Base\Handler\Handler
{
	use HandlerTrait;

    /**
     * @Inject
     * @var \Hetwan\Helper\AccountHelper
     */
    private $accountHelper;

	public function handle(string $data) : bool
	{
		switch ($data[1]) {
			case 'A':
				$this->createPlayer($data);

				break;
			case 'D':
				$this->deletePlayer($data);

				break;
			case 'f':
				$this->doQueue();

				break;
			case 'i':
				$this->assignKey($data);

				break;
			case 'L':
				$this->playersList();

				break;
            case 'M':
                $this->playerMigration($data);

                break;
			case 'P':
				$this->generatePlayerName();

				break;
			case 'S':
				$this->playerSelection($data);

				break;
			case 'V':
				$this->regionalVersion();

				break;
		}

		return true;
	}

	private function createPlayer(string $data) : void
	{
	    list($name, $breed, $gender, $colorOne, $colorTwo, $colorThree) = explode('|', substr($data, 2));

		if ($this->getAccount()->getPlayers() !== null and array_sum($this->getAccount()->getPlayers()) >= $this->getAccount()->getMaxPlayers()) {
            $this->send(PlayerMessageFormatter::maxPlayersReachedMessage());
        } elseif (!(strlen($name) >= 2 and strlen($name) <= 20) or !preg_match('/^[a-zA-Z-]/', $name)) {
            $this->send(PlayerMessageFormatter::invalidPlayerNameMessage());
        } elseif ($this->entityManager->get()->getRepository(PlayerEntity::class)->countByNameCaseInsensitive($name) > 0) {
            $this->send(PlayerMessageFormatter::playerNameAlreadyTakenMessage());
        } else {
            $breedData = BreedHelper::getFromId($breed);

            $player = new PlayerEntity;
            $player->setAccountId($this->getAccount()->getId())
                   ->setName($name)
                   ->setBreed($breed)
                   ->setGender($gender)
                   ->setColors($colorOne . ';' . $colorTwo . ';' . $colorThree)
                   ->setLifePoints($breedData['startLifePoints'])
                   ->setMaximumLifePoints($player->getLifePoints())
                   ->setActionPoints($breedData['startActionPoints'])
                   ->setMovementPoints($breedData['startMovementPoints'])
                   ->setLevel(1)
                   ->setExperience(0)
                   ->setSkinId($breed . $gender)
                   ->setFaction(0)
                   ->setFactionHonorPoints(-1)
                   ->setFactionDishonorPoints(-1)
                   ->setMapId($breedData['startMapId'])
                   ->setCellId($breedData['startCellId']);

            // Insert player

            $this->entityManager->get()
                                ->persist($player);

            $this->entityManager->get()
                                ->flush();

            // Append to the current account the player

            $players = $this->getAccount()->getPlayers();
            $accountPlayersOnServer = isset($players[($serverId = $this->configuration->get('server.id'))]);

            if ($accountPlayersOnServer) {
                $players[$serverId][] = $player->getId();
            } else {
                $players[$serverId] = [$player->getId()];
            }

			$this->getAccount()->setPlayers($players);

            unset($players);

            // Update account

            $this->entityManager->get('login')
                                ->persist($this->getAccount());

            $this->entityManager->get('login')
                                ->flush();

			$this->send(PlayerMessageFormatter::playerCreatedMessage());

			$this->playersList(); // Refreshing players list
		}
	}

	private function deletePlayer(string $data) : void
	{
		list($playerId, $secretAnswer) = explode('|', substr($data, 2));

		if ((!$secretAnswer or $secretAnswer === $this->getAccount()->getSecretAnswer()) and
            ($player = $this->accountHelper->hasPlayer($playerId, $this->getAccount()->getPlayers(), true))
        ) {
		    // Remove account player

		    $players = $this->getAccount()->getPlayers();

		    unset($players[array_search($player->getId(), $players)]);

            $this->getAccount()->setPlayers($players);

            $this->entityManager->persist($this->getAccount(), 'login');

            // Remove player

			$this->entityManager->remove($player);

			$this->playersList();
		} else {
            $this->send(PlayerMessageFormatter::playerDeletetionFailureMessage());
        }
	}

	private function doQueue() : void // TODO: make queue system
	{
		$this->send(GameMessageFormatter::queueMessage(1, 0, 0, 1));
	}

	private function assignKey(string $data) : void
	{
		$this->client->setKey(substr($data, 2));
	}

	private function playerMigration(string $data) : void
    {
        list($playerId, $newPlayerName) = explode(';', substr($data, 2));

        $this->send(PlayerMessageFormatter::playersListMessage(
            $this->getAccount(),
            $this->accountHelper->getPlayers($this->getAccount()->getId()),
            $this->configuration->get('server.id')
        ));
    }

	private function generatePlayerName() : void
	{
		$this->send(PlayerMessageFormatter::generatedPlayerNameMessage(PlayerHelper::generateRandomName()));
	}

	private function playersList() : void
	{
		$this->send(PlayerMessageFormatter::playersListMessage(
            $this->getAccount(),
            $this->accountHelper->getPlayers($this->getAccount()->getId()),
			$this->configuration->get('server.id')
		));
	}

	private function playerSelection(string $data) : void
	{
		$playerId = substr($data, 2);

		if ($playerId === 'NaN') {
		    return;
        }

		$player = $this->accountHelper->hasPlayer($playerId, $this->getAccount()->getPlayers(), true);

		if ($player !== null) {
			$this->client->setPlayer($player);

			$this->send(ApproachMessageFormatter::playerSelectionMessage($player));

			$this->client->setHandler(GameHandlerContainer::class);
		}
	}

	private function regionalVersion() : void
	{
		$this->send(ApproachMessageFormatter::regionalVersionResponseMessage($this->getAccount()->getCommunity()));
	}
}