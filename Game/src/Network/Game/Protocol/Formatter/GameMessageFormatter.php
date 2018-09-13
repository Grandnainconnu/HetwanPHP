<?php

namespace Hetwan\Network\Game\Protocol\Formatter;

use Hetwan\Helper\ItemHelper;
use Hetwan\Helper\Player\PlayerHelper;
use Hetwan\Network\Game\Protocol\Enum\ItemPositionEnum;


trait ActorBuilderTrait
{
	private static function buildPlayerActorMessage(\Hetwan\Entity\Game\PlayerEntity $actor)
	{
		$colors = explode(';', PlayerHelper::getConvertedColors($actor->getColors()));

		return [
			$actor->getName(), 
			$actor->getBreed(), 
			$actor->getSkinId() . '^' . '100', //TODO: actor size
			$actor->getGender(),
			$actor->getFaction(),
			$colors[0],
			$colors[1],
			$colors[2],
			ItemHelper::formatAccessories(ItemHelper::getWithPositions(ItemPositionEnum::ACCESSORY, $actor->getItems())),
			($actor->getLevel() >= 100) ? ($actor->getLevel() >= 200) ? 200 : 100  : 0,
			null, //TODO: emotes
			null, //TODO: emotes timer
			null, //TODO: guild name
			null, //TODO: guild emblem
			0,
			null, // TODO: speed restrictions
			null // TODO: mount
		];
	}
}

class GameMessageFormatter
{
	use ActorBuilderTrait;

	public static function queueMessage($position, $subscribers, $nonSubscribers, $isSubscriber, $queuId = 1)
	{
		return 'Af' . $position . '|' . $subscribers . '|' . $nonSubscribers . '|' . $isSubscriber . '|' . $queuId;
	}

	public static function playerLoadedMessage($playerName, $succeed = true)
	{
		return 'GCK|' . (int)$succeed . '|' . $playerName;
	}

	public static function playerRegenerationIntervalMessage($interval)
	{
		return 'ILS' . $interval;
	}

	public static function mapFightCountMessage($fights)
	{
		return 'fC' . (int)$fights;
	}

	public static function playerStatisticsMessage(\Hetwan\Entity\Game\PlayerEntity $player, array $experience)
    {
		$packet = [
			'As' . implode(',', [$player->getExperience(), $experience[0]['player'], $experience[1]['player']]),
			$player->getKamas(), 
			$player->getPointsOfCharacteristics(), 
			$player->getSpellPoints(), 
			$player->getFaction(),
			$player->getTotalLifePoints() . ',' . $player->getTotalMaximumLifePoints(),
			$player->getEnergy() . ',' . 10000,
			$player->getCharacteristics()->getCharacteristic('initiative')->getTotal(),
			$player->getCharacteristics()->getCharacteristic('prospection')->getTotal(),
			implode(',', [$player->getCharacteristics()->getCharacteristic('ap')->getBase(), $player->getCharacteristics()->getCharacteristic('ap')->getBonus(), $player->getCharacteristics()->getCharacteristic('ap')->getGift(), $player->getCharacteristics()->getCharacteristic('ap')->getContext(), $player->getCharacteristics()->getCharacteristic('ap')->getTotal()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('mp')->getBase(), $player->getCharacteristics()->getCharacteristic('mp')->getBonus(), $player->getCharacteristics()->getCharacteristic('mp')->getGift(), $player->getCharacteristics()->getCharacteristic('mp')->getContext(), $player->getCharacteristics()->getCharacteristic('mp')->getTotal()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('strength')->getBase(), $player->getCharacteristics()->getCharacteristic('strength')->getBonus(), $player->getCharacteristics()->getCharacteristic('strength')->getGift(), $player->getCharacteristics()->getCharacteristic('strength')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('vitality')->getBase(), $player->getCharacteristics()->getCharacteristic('vitality')->getBonus(), $player->getCharacteristics()->getCharacteristic('vitality')->getGift(), $player->getCharacteristics()->getCharacteristic('vitality')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('wisdom')->getBase(), $player->getCharacteristics()->getCharacteristic('wisdom')->getBonus(), $player->getCharacteristics()->getCharacteristic('wisdom')->getGift(), $player->getCharacteristics()->getCharacteristic('wisdom')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('chance')->getBase(), $player->getCharacteristics()->getCharacteristic('chance')->getBonus(), $player->getCharacteristics()->getCharacteristic('chance')->getGift(), $player->getCharacteristics()->getCharacteristic('chance')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('agility')->getBase(), $player->getCharacteristics()->getCharacteristic('agility')->getBonus(), $player->getCharacteristics()->getCharacteristic('agility')->getGift(), $player->getCharacteristics()->getCharacteristic('agility')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('intelligence')->getBase(), $player->getCharacteristics()->getCharacteristic('intelligence')->getBonus(), $player->getCharacteristics()->getCharacteristic('intelligence')->getGift(), $player->getCharacteristics()->getCharacteristic('intelligence')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('sp')->getBase(), $player->getCharacteristics()->getCharacteristic('sp')->getBonus(), $player->getCharacteristics()->getCharacteristic('sp')->getGift(), $player->getCharacteristics()->getCharacteristic('sp')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('summon')->getBase(), $player->getCharacteristics()->getCharacteristic('summon')->getBonus(), $player->getCharacteristics()->getCharacteristic('summon')->getGift(), $player->getCharacteristics()->getCharacteristic('summon')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('damage')->getBase(), $player->getCharacteristics()->getCharacteristic('damage')->getBonus(), $player->getCharacteristics()->getCharacteristic('damage')->getGift(), $player->getCharacteristics()->getCharacteristic('damage')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('physical_damage')->getBase(), $player->getCharacteristics()->getCharacteristic('physical_damage')->getBonus(), $player->getCharacteristics()->getCharacteristic('physical_damage')->getGift(), $player->getCharacteristics()->getCharacteristic('physical_damage')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('magical_damage')->getBase(), $player->getCharacteristics()->getCharacteristic('magical_damage')->getBonus(), $player->getCharacteristics()->getCharacteristic('magical_damage')->getGift(), $player->getCharacteristics()->getCharacteristic('physical_damage')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('percent_damage')->getBase(), $player->getCharacteristics()->getCharacteristic('percent_damage')->getBonus(), $player->getCharacteristics()->getCharacteristic('percent_damage')->getGift(), $player->getCharacteristics()->getCharacteristic('percent_damage')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('heal')->getBase(), $player->getCharacteristics()->getCharacteristic('heal')->getBonus(), $player->getCharacteristics()->getCharacteristic('heal')->getGift(), $player->getCharacteristics()->getCharacteristic('heal')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('trap_damage')->getBase(), $player->getCharacteristics()->getCharacteristic('trap_damage')->getBonus(), $player->getCharacteristics()->getCharacteristic('trap_damage')->getGift(), $player->getCharacteristics()->getCharacteristic('trap_damage')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('trap_percent_damage')->getBase(), $player->getCharacteristics()->getCharacteristic('trap_percent_damage')->getBonus(), $player->getCharacteristics()->getCharacteristic('trap_percent_damage')->getGift(), $player->getCharacteristics()->getCharacteristic('trap_percent_damage')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('return_damage')->getBase(), $player->getCharacteristics()->getCharacteristic('return_damage')->getBonus(), $player->getCharacteristics()->getCharacteristic('return_damage')->getGift(), $player->getCharacteristics()->getCharacteristic('return_damage')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('critical_damage')->getBase(), $player->getCharacteristics()->getCharacteristic('critical_damage')->getBonus(), $player->getCharacteristics()->getCharacteristic('critical_damage')->getGift(), $player->getCharacteristics()->getCharacteristic('critical_damage')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('critical_failure')->getBase(), $player->getCharacteristics()->getCharacteristic('critical_failure')->getBonus(), $player->getCharacteristics()->getCharacteristic('critical_failure')->getGift(), $player->getCharacteristics()->getCharacteristic('critical_failure')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('dodge_ap')->getBase(), $player->getCharacteristics()->getCharacteristic('dodge_ap')->getBonus(), $player->getCharacteristics()->getCharacteristic('dodge_ap')->getGift(), $player->getCharacteristics()->getCharacteristic('dodge_ap')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('dodge_mp')->getBase(), $player->getCharacteristics()->getCharacteristic('dodge_mp')->getBonus(), $player->getCharacteristics()->getCharacteristic('dodge_mp')->getGift(), $player->getCharacteristics()->getCharacteristic('dodge_mp')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('neutral_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('neutral_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('neutral_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('neutral_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('neutral_percent_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('neutral_percent_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('neutral_percent_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('neutral_percent_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('earth_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('earth_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('earth_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('earth_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('earth_percent_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('earth_percent_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('earth_percent_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('earth_percent_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('fire_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('fire_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('fire_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('fire_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('fire_percent_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('fire_percent_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('fire_percent_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('fire_percent_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('water_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('water_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('water_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('water_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('water_percent_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('water_percent_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('water_percent_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('water_percent_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('air_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('air_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('air_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('air_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('air_percent_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('air_percent_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('air_percent_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('air_percent_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('pvp_neutral_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('pvp_neutral_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('pvp_neutral_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('pvp_neutral_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('pvp_neutral_percent_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('pvp_neutral_percent_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('pvp_neutral_percent_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('pvp_neutral_percent_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('pvp_earth_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('pvp_earth_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('pvp_earth_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('pvp_earth_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('pvp_earth_percent_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('pvp_earth_percent_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('pvp_earth_percent_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('pvp_earth_percent_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('pvp_fire_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('pvp_fire_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('pvp_fire_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('pvp_fire_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('pvp_fire_percent_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('pvp_fire_percent_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('pvp_fire_percent_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('pvp_fire_percent_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('pvp_water_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('pvp_water_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('pvp_water_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('pvp_water_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('pvp_water_percent_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('pvp_water_percent_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('pvp_water_percent_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('pvp_water_percent_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('pvp_air_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('pvp_air_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('pvp_air_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('pvp_air_damage_reduce')->getContext()]),
			implode(',', [$player->getCharacteristics()->getCharacteristic('pvp_air_percent_damage_reduce')->getBase(), $player->getCharacteristics()->getCharacteristic('pvp_air_percent_damage_reduce')->getBonus(), $player->getCharacteristics()->getCharacteristic('pvp_air_percent_damage_reduce')->getGift(), $player->getCharacteristics()->getCharacteristic('pvp_air_percent_damage_reduce')->getContext()]),
		];

		return implode('|', $packet);
	}

	public static function mapDataMessage($id, $date, $key)
	{
		return 'GDM|' . $id . '|' . $date . '|' . $key;
	}

	public static function mapLoadedMessage()
	{
		return 'GDK';
	}

	public static function showActorsMessage(array $actors)
	{
		$packet = ['GM'];

		foreach ($actors as $actor) {
			$packet[] = '|+' . implode(';', array_merge([$actor->getCellId(), $actor->getOrientation(), 0, $actor->getId()], self::buildPlayerActorMessage($actor)));
		}

		return implode('', $packet);
	}

	public static function updateActorsMessage(array $actors)
	{
		$packet = ['GM'];

		foreach ($actors as $actor) {
			$packet[] = '|~' . implode(';', array_merge([$actor->getCellId(), $actor->getOrientation(), 0, $actor->getId()], self::buildPlayerActorMessage($actor)));
		}

		return implode('', $packet);
	}

	public static function removeActorsMessage(array $actors)
	{
		$packet = ['GM'];

		foreach ($actors as $actorId) {
			$packet[] = '|-' . $actorId;
		}

		return implode('', $packet);
	}

	public static function actorMovementMessage($actorId, $path)
	{
		return 'GA1;1;' . $actorId . ';' . $path;
	}
}