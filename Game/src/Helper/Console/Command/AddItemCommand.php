<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-30 19:45:55
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-31 13:55:56
 */

namespace Hetwan\Helper\Console\Command;

use Hetwan\Helper\Console\ConsoleHelper;
use Hetwan\Helper\ItemHelper;

use Hetwan\Network\Game\Protocol\Formatter\ItemMessageFormatter;


class AddItemCommand extends AbstractCommand
{
	public function __construct()
	{
		$this->name = 'add_item';
		$this->description = 'Add item';
		$this->arguments = [
			new CommandArgument('itemId', 'Id of the item', CommandArgument::INTEGER, CommandArgument::NO_FILTER),
			new CommandArgument('maxJet', 'Maximum jet generation', CommandArgument::BOOLEAN, CommandArgument::NO_FILTER, CommandArgument::NO_FILTER, false),
			new CommandArgument('players', 'Targeted players (separated by a comma)', CommandArgument::STRING, CommandArgument::FILTER_COMMA, false)
		];
	}

	public function execute($arguments, $playerId)
	{
		$targettedPlayers = [];

		if (($item = ItemHelper::generateItem($arguments[0], !isset($arguments[1]) ? false : (bool) $arguments[1])) == null)
			return $this->errorMessage(sprintf("Item '%d' doesn't exists", $arguments[0]));

		foreach ((!isset($arguments[2]) ? [$playerId] : $arguments[2]) as $playerId)
		{
			$toGiveItem = $item;

			$toGiveItem
				->setPlayerId($playerId)
				->save();

			if (($client = \Hetwan\Network\Game\GameServer::getClientWithPlayer($playerId)) != null)
			{
				$client->send(ItemMessageFormatter::addItemMessage($toGiveItem));

				$client->getPlayer()->refreshInventoryItems();

				$targettedPlayers[] = $playerId;
			}
		}

		return $this->successMessage(sprintf('Player(s) [%s] have successfully received their item.', implode(', ', $targettedPlayers)));
	}
}