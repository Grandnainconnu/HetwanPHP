<?php

/**
 * @Author: jean
 * @Date:   2017-09-18 13:48:16
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-30 18:36:13
 */

namespace Hetwan\Helper\Player;

use Hetwan\Helper\AbstractHelper;
use Hetwan\Helper\MapDataHelper;

use Hetwan\Network\Game\Protocol\Enum\ItemPositionEnum;

use Hetwan\Network\Game\Protocol\Formatter\GameMessageFormatter;


trait NameGeneratorTrait
{
    public static function generate()
   	{
   		static $beginning = [
	    	'Kr', 'Ca', 'Ra', 'Mrok', 'Cru',
	        'Ray', 'Bre', 'Zed', 'Drak', 'Mor', 'Jag', 'Mer', 'Jar', 'Mjol',
	        'Zork', 'Mad', 'Cry', 'Zur', 'Creo', 'Azak', 'Azur', 'Rei', 'Cro',
	        'Mar', 'Luk'
	    ];

	    static $middle = [
	    	'air', 'ir', 'mi', 'sor', 'mee', 'clo',
	        'red', 'cra', 'ark', 'arc', 'miri', 'lori', 'cres', 'mur', 'zer',
	        'marac', 'zoir', 'slamar', 'salmar', 'urak'
	    ];
	    
	    static $ending = [
	    	'd', 'ed', 'ark', 'arc', 'es', 'er', 'der',
	        'tron', 'med', 'ure', 'zur', 'cred', 'mur'
	    ];

		return $beginning[rand(0, count($beginning) - 1)] . $middle[rand(0, count($middle) - 1)] . $ending[rand(0, count($ending) - 1)];
    }
}

class PlayerHelper extends AbstractHelper
{
	public static function generatePlayerName()
	{
		return NameGeneratorTrait::generate();
	}

	public static function createPlayer($name, $breed, $gender, $colors, $serverId)
	{
		$player = new \Hetwan\Entity\Login\Player();
		$breedData = Breed\BreedHelper::getBreedFromId((int) $breed);

		$player->setName($name)
		 	   ->setBreed($breed)
			   ->setGender($gender)
			   ->setColors($colors[0] . ';' . $colors[1] . ';' . $colors[2])
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
			   ->setCellId($breedData['startCellId'])
			   ->setServerId($serverId);

		return $player;
	}

	public static function getPlayerAccessories(\Hetwan\Entity\Login\Player $player)
	{
		$accessories = [
			ItemPositionEnum::CAP => null,
			ItemPositionEnum::MANTLE => null,
			ItemPositionEnum::ANIMAL => null,
			ItemPositionEnum::SHIELD => null
		];

		foreach ($player->getEquipedItems() as $accessory)
			if (array_key_exists($accessory->getPosition(), $accessories))
				$accessories[$accessory->getPosition()] = dechex($accessory->getItemData()->getId());

		return ',' . implode(',', $accessories);
	}

	public static function playerCanReceiveFromPlayer(\Hetwan\Entity\Login\Player $sender, $receiver)
	{
		if ($receiver == null)
			return (false);

		return (true);
	}

	public static function teleport(\Hetwan\Network\Game\GameClient $client, $mapData, $cellId)
	{
		$client->send(GameMessageFormatter::mapDataMessage(
			$mapData->getId(), 
			$mapData->getDate(),
			$mapData->getKey()
		));

		MapDataHelper::removePlayerInMap((int) $client->getPlayer()->getMapId(), $client->getPlayer());

		$client->getPlayer()->setMapId($mapData->getId());
		$client->getPlayer()->setCellId($cellId);
	}
}