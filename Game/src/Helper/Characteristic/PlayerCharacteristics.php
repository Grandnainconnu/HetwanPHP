<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-28 21:17:17
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-30 19:38:26
 */

namespace Hetwan\Helper\Characteristic;


final class PodsCharacteristic extends Characteristic
{
	private $current;

	public function __construct(Characteristic $characteristic)
	{
		parent::__construct(
			$characteristic->getCharacteristicId(), 
			$characteristic->getBase(), 
			$characteristic->getBonus(), 
			$characteristic->getGift(), 
			$characteristic->getContext()
		);
	}

	public function setCurrent($pods)
	{
		$this->current = $pods;

		return $this;
	}

	public function getCurrent()
	{
		return $this->current;
	}

	public function apply($player)
	{
		$this->base = 1000 + $player->getCharacteristics()->getCharacteristic('strength')->getTotal() * 5;

		$this->setCurrent(\Hetwan\Helper\ItemHelper::getPlayerTakenPods($player));
	}
}

final class ProspectionCharacteristic extends Characteristic
{
	public function __construct(Characteristic $characteristic)
	{
		parent::__construct(
			$characteristic->getCharacteristicId(), 
			$characteristic->getBase(), 
			$characteristic->getBonus(), 
			$characteristic->getGift(), 
			$characteristic->getContext()
		);
	}

	public function apply($player)
	{
		$breedData = \Hetwan\Helper\Player\Breed\BreedHelper::getBreedFromId((int) $player->getBreed());

		$this->base = ($player->getCharacteristics()->getCharacteristic('chance')->getTotal() / 10) + $breedData['startProspection'];
	}
}

final class InitiativeCharacteristic extends Characteristic
{
	public function __construct(Characteristic $characteristic)
	{
		parent::__construct(
			$characteristic->getCharacteristicId(), 
			$characteristic->getBase(), 
			$characteristic->getBonus(), 
			$characteristic->getGift(), 
			$characteristic->getContext()
		);
	}

	public function apply($player)
	{
		$this->base = ($player->getCharacteristics()->getCharacteristic('chance')->getBase() + $player->getCharacteristics()->getCharacteristic('intelligence')->getBase() + $player->getCharacteristics()->getCharacteristic('strength')->getBase() + $player->getCharacteristics()->getCharacteristic('agility')->getBase()) * ($player->getLifePoints() / $player->getMaximumLifePoints());
	}
}

final class PlayerCharacteristics
{
	private $characteristics = [];

	public function __construct($player)
	{
		$this->characteristics = [
			'ap' => $player->getActionPoints(),
			'mp' => $player->getMovementPoints(),
			'sp' => 0,
			'pods' => 0,
			'initiative' => 0,
			'prospection' => 0,
			'strength' => $player->getBaseStrength() + $player->getStrength(),
			'vitality' => $player->getBaseVitality() + $player->getVitality(),
			'wisdom' => $player->getBaseWisdom() + $player->getWisdom(),
			'intelligence' => $player->getBaseIntelligence() + $player->getIntelligence(),
			'chance' => $player->getBaseChance() + $player->getChance(),
			'agility' => $player->getBaseAgility() + $player->getAgility(),
			'summon' => 1,
			'damage' => 0,
			'percent_damage' => 0,
			'physical_damage' => 0,
			'magical_damage' => 0,
			'trap_damage' => 0,
			'trap_percent_damage' => 0,
			'heal' => 0,
			'return_damage' => 0,
			'critical_damage' => 0,
			'critical_failure' => 0,
			'dodge_ap' => 0,
			'dodge_mp' => 0,
			'neutral_damage_reduce' => 0,
			'neutral_percent_damage_reduce' => 0,
			'earth_damage_reduce' => 0,
			'earth_percent_damage_reduce' => 0,
			'fire_damage_reduce' => 0,
			'fire_percent_damage_reduce' => 0,
			'water_damage_reduce' => 0,
			'water_percent_damage_reduce' => 0,
			'air_damage_reduce' => 0,
			'air_percent_damage_reduce' => 0,
			'pvp_neutral_damage_reduce' => 0,
			'pvp_neutral_percent_damage_reduce' => 0,
			'pvp_earth_damage_reduce' => 0,
			'pvp_earth_percent_damage_reduce' => 0,
			'pvp_fire_damage_reduce' => 0,
			'pvp_fire_percent_damage_reduce' => 0,
			'pvp_water_damage_reduce' => 0,
			'pvp_water_percent_damage_reduce' => 0,
			'pvp_air_damage_reduce' => 0,
			'pvp_air_percent_damage_reduce' => 0,
		];

		foreach ($this->characteristics as $characteristicId => $value)
			$this->characteristics[$characteristicId] = self::makeCharacteristic($characteristicId, $value, $player->getEquipedItemsBonus());

		$this->characteristics['initiative'] = new InitiativeCharacteristic($this->characteristics['initiative']);
		$this->characteristics['pods'] = new PodsCharacteristic($this->characteristics['pods']);
		$this->characteristics['prospection'] = new ProspectionCharacteristic($this->characteristics['prospection']);
	}

	public function updateCharacteristicsBonus(array $equipedItemsBonus)
	{
		$characteristicsToUpdate = [];

		foreach ($equipedItemsBonus as $effectId => $effectValue)
		{
			preg_match('/([a-zA-Z]+)_(.*)/', strtolower($effectId), $matches);

			if (!in_array($matches[1], ['add', 'sub']))
			{
				$matches[2] = $matches[1];
				$matches[1] = 'add';
			}

			$characteristicsToUpdate[$matches[2]] = ($matches[1] == 'add') ? $effectValue : - $effectValue;
		}

		foreach ($this->characteristics as $characteristicId => $characteristic)
			$this->getCharacteristic($characteristicId)->setBonus(array_key_exists($characteristicId, $characteristicsToUpdate) ? $characteristicsToUpdate[$characteristicId] : 0);
	}

	public function updateSecondaryCharacteristics($player)
	{
		$this->getCharacteristic('initiative')->apply($player);
		$this->getCharacteristic('pods')->apply($player);
		$this->getCharacteristic('prospection')->apply($player);
	}

	public function getCharacteristic(string $characteristicName)
	{
		if (array_key_exists($characteristicName, $this->characteristics))
			return $this->characteristics[$characteristicName];
	}

	public static function makeCharacteristic(string $characteristicId, $playerBase = 0, array $equipedItemsBonus = [])
	{
		$playerBonus = 0;

		foreach ($equipedItemsBonus as $effectId => $effectValue)
			if ($effectId == strtoupper('add_' . $characteristicId))
				$playerBonus += (int) $effectValue;
			elseif ($effectId == strtoupper('sub_' . $characteristicId))
				$playerBonus -= (int) $effectValue;

		return new Characteristic($characteristicId, $playerBase, $playerBonus);
	}
}