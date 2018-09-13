<?php

namespace Hetwan\Helper\Characteristic\Player;

use Hetwan\Helper\Characteristic\Base\Characteristic;
use Hetwan\Helper\Characteristic\Player\Characteristic\{
    PodsCharacteristic,
    InitiativeCharacteristic,
    ProspectionCharacteristic
};
use Hetwan\Helper\ItemEffectHelper;
use Hetwan\Helper\ItemHelper;
use Hetwan\Helper\Player\Breed\BreedHelper;
use Hetwan\Network\Game\Protocol\Enum\ItemPositionEnum;


final class Characteristics
{
    /**
     * @var array
     */
    private $characteristics = [];

    public function __construct(\Hetwan\Entity\Game\PlayerEntity $player)
    {
        $breedData = BreedHelper::getFromId($player->getBreed());
        $specialsCharacteristics = [
            'pods' => PodsCharacteristic::class,
            'initiative' => InitiativeCharacteristic::class,
            'prospection' => ProspectionCharacteristic::class
        ];

        $this->characteristics = [
            'ap' => $player->getActionPoints(),
            'mp' => $player->getMovementPoints(),
            'sp' => 0,
            'pods' => 0,
            'initiative' => 0,
            'prospection' => $breedData['startProspection'],
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

        foreach ($this->characteristics as $characteristicId => $value) {
            $characteristic = self::createCharacteristic(
                $characteristicId,
                $value,
                ItemEffectHelper::getFromItems(
                    ItemHelper::getWithPositions(ItemPositionEnum::EQUPMENT, $player->getItems())
                )
            );

            if (array_key_exists($characteristicId, $specialsCharacteristics)) {
                $this->characteristics[$characteristicId] = new $specialsCharacteristics[$characteristicId]($characteristic, $player);
            } else {
                $this->characteristics[$characteristicId] = $characteristic;
            }
        }
    }

    public function updateCharacteristicsBonus(array $items, bool $remove = false) : void
    {
        $characteristicsToUpdate = [];

        foreach ($items as $item) {
            $effects = $item->getParsedEffects();

            foreach ($effects as $effectId => $effectValue) {
                preg_match('/([a-zA-Z]+)_(.*)/', strtolower($effectId), $matches);

                if (!in_array($matches[1], ['add', 'sub'])) {
                    $matches[2] = $matches[1];
                    $matches[1] = 'add';
                }

                $characteristicsToUpdate[$matches[2]] = ($matches[1] == 'add') ? $effectValue : -$effectValue;
            }
        }

        foreach ($characteristicsToUpdate as $characteristicId => $value) {
            if (($characteristic = $this->getCharacteristic($characteristicId)) !== null) {
                $newBonus = $characteristic->getBonus() + ((!$remove) ? $value : -$value);

                $characteristic->setBonus($newBonus);
            }
        }
    }

    public static function createCharacteristic(string $characteristicId, int $base = 0, array $equipedItemsBonus = []) : \Hetwan\Helper\Characteristic\Base\Characteristic
    {
        $bonus = 0;

        foreach ($equipedItemsBonus as $effectId => $effectValue) {
            if ((string)$effectId === strtoupper('add_' . $characteristicId)) {
                $bonus += $effectValue;
            } elseif ((string)$effectId === strtoupper('sub_' . $characteristicId)) {
                $bonus -= $effectValue;
            }
        }

        return new Characteristic($characteristicId, $base, $bonus);
    }

    public function getCharacteristic(string $characteristicName) : ?\Hetwan\Helper\Characteristic\Base\Characteristic
    {
        if (array_key_exists($characteristicName, $this->characteristics)) {
            return $this->characteristics[$characteristicName];
        }

        return null;
    }
}