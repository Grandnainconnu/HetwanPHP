<?php

namespace Hetwan\Helper\Player;


final class PlayerHelper
{
	/**
     * @Inject
	 * @var \Hetwan\Network\Game\GameServer 
	 */
	private $gameServer;

	public static function generateRandomName() : string
	{
        $beginning = [
            'Kr', 'Ca', 'Ra', 'Mrok', 'Cru',
            'Ray', 'Bre', 'Zed', 'Drak', 'Mor', 'Jag', 'Mer', 'Jar', 'Mjol',
            'Zork', 'Mad', 'Cry', 'Zur', 'Creo', 'Azak', 'Azur', 'Rei', 'Cro',
            'Mar', 'Luk'
        ];
        $middle = [
            'air', 'ir', 'mi', 'sor', 'mee', 'clo',
            'red', 'cra', 'ark', 'arc', 'miri', 'lori', 'cres', 'mur', 'zer',
            'marac', 'zoir', 'slamar', 'salmar', 'urak'
        ];
        $ending = [
            'd', 'ed', 'ark', 'arc', 'es', 'er', 'der',
            'tron', 'med', 'ure', 'zur', 'cred', 'mur'
        ];

        return $beginning[rand(0, count($beginning) - 1)] . $middle[rand(0, count($middle) - 1)] . $ending[rand(0, count($ending) - 1)];
	}

	public static function canReceiveFrom(\Hetwan\Entity\Game\PlayerEntity $sender, $receiver) : bool
	{
		if ($receiver === null) {
			return false;
		}

		return true;
	}

    public static function getTakenPods(\Hetwan\Entity\Game\PlayerEntity $player) : int
    {
        $takenPods = 0;
        $items = $player->getItems();

        foreach ($items as $item) {
            $takenPods += $item->getItemData()->getWeight();
        }

        unset($items);

        return $takenPods;
    }

    public static function getConvertedColors(string $colors, string $separator = ';') : string
    {
        $convertedColors = [];

        foreach (explode(';', $colors) as $color) {
            $convertedColors[] = (($color != '-1') ? dechex($color) : $color);
        }

        return implode($separator, $convertedColors);
    }

	public function getClient(\Hetwan\Entity\Game\PlayerEntity $player) : ?\Hetwan\Network\Game\GameClient
	{
		$clients = $this->gameServer->getClientsPool();

		foreach ($clients as $client) {
			if (($clientPlayer = $client->getPlayer()) and $clientPlayer === $player) {
				return $client;
			}
		}

		unset($clients);

		return null;
	}

	public function getClientWithId(int $playerId) : ?\Hetwan\Network\Game\GameClient
	{
		$clients = $this->gameServer->getClientsPool();

		foreach ($clients as $client) {
			if (($clientPlayer = $client->getPlayer()) and $clientPlayer->getId() === $playerId) {
				return $client;
			}
		}

		unset($clients);

		return null;
	}

    public function getClientWithName(string $playerName) : ?\Hetwan\Network\Game\GameClient
    {
        $clients = $this->gameServer->getClientsPool();

        foreach ($clients as $client) {
            if (($clientPlayer = $client->getPlayer()) and $clientPlayer->getName() === $playerName) {
                return $client;
            }
        }

        unset($clients);

        return null;
    }
}