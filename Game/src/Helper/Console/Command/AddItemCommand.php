<?php

namespace Hetwan\Helper\Console\Command;

use Hetwan\Helper\Console\Command\Base\CommandArgument;
use Hetwan\Network\Game\Protocol\Formatter\ItemMessageFormatter;


final class AddItemCommand extends \Hetwan\Helper\Console\Command\Base\Command
{
    /**
     * @Inject
     * @var \Hetwan\Core\EntityManager
     */
    private $entityManager;

    /**
     * @Inject
     * @var \Hetwan\Helper\ItemHelper
     */
    private $itemHelper;

	/**
	 * @Inject
	 * @var \Hetwan\Helper\Player\PlayerHelper
	 */
	private $playerHelper;

	public function __construct()
	{
		$this->name = 'add_item';
		$this->description = 'Add item';
		$this->arguments = [
			new CommandArgument('itemId', 'Id of the item', CommandArgument::INTEGER, CommandArgument::NO_FILTER),
            new CommandArgument('quantity', 'Desired quantity', CommandArgument::INTEGER, CommandArgument::NO_FILTER),
			new CommandArgument('maxJet', 'Maximum jet generation', CommandArgument::BOOLEAN, CommandArgument::NO_FILTER, CommandArgument::NO_FILTER, false),
			new CommandArgument('players', 'Targeted players (separated by a comma)', CommandArgument::STRING, CommandArgument::FILTER_COMMA, false)
		];
	}

	public function execute(array $arguments, int $playerId)
	{
		$targettedPlayers = [];

		if (($item = $this->itemHelper->generate($arguments[0], $arguments[1], !isset($arguments[2]) ? false : (bool)$arguments[2])) === null) {
			return $this->errorMessage('Item ' . $arguments[0] . ' doesn\'t exists');
		}

		$players = (!isset($arguments[3]) ? [$playerId] : $arguments[3]);

		foreach ($players as $playerId) {
			$toGiveItem = $item;

			if (($client = $this->playerHelper->getClientWithId($playerId)) !== null) {
			    $toGiveItem->setPlayer($client->getPlayer());
			    $client->getPlayer()->addItem($toGiveItem);

			    $this->entityManager->persist($toGiveItem);
			    $this->entityManager->get()->flush($toGiveItem);

				$client->send(ItemMessageFormatter::addItemMessage($toGiveItem));

				$targettedPlayers[] = $playerId;
			}
		}

		unset($players);

		return $this->successMessage('Player(s) [' . implode(', ', $targettedPlayers) . '] have successfully received their item.');
	}
}