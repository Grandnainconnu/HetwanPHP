<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-18 17:53:42
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-18 18:12:59
 */

namespace Hetwan\Network\Game\Protocol\Enum;


class CharacteristicTypeEnum extends AbstractEnum
{
	const UNKNOWN = -1,
		  LIFE = 0,
		  PROSPECTION = 1,
    	  INITIATIVE = 2,
          AP = 3,
          MP = 4,
          STRENGTH = 5,
          VITALITY = 6,
          WISDOM = 7,
          CHANCE = 8,
          AGILITY = 9,
          INTELLIGENCE = 10,
          RP = 11,
          SUMMON = 12,
          DAMAGE = 13,
          PHYSICAL_DAMAGE = 14,
          MAGICAL_DAMAGE = 15,
          PERCENT_DAMAGE = 16,
          HEAL = 17,
          TRAP_DAMAGE = 18,
          TRAP_DAMAGE_PERCENT = 19,
          DAMAGE_RETURN = 20,
          CRITICAL_HIT = 21,
          CRITICAL_FAILURE = 22,
          DODGE_AP = 23,
          DODGE_MP = 24,
          NEUTRAL_DAMAGE_REDUCE = 25,
          NEUTRAL_PERCENT_DAMAGE_REDUCE = 26,
          PVP_NEUTRAL_DAMAGE_REDUCE = 27,
          PVP_NEUTRAL_PERCENT_DAMAGE_REDUCE = 28,
          EARTH_DAMAGE_REDUCE = 29,
          EARTH_PERCENT_DAMAGE_REDUCE = 30,
          PVP_EARTH_DAMAGE_REDUCE = 31,
          PVP_EARTH_PERCENT_DAMAGE_REDUCE = 32,
          WATER_DAMAGE_REDUCE = 33,
          WATER_PERCENT_DAMAGE_REDUCE = 34,
          PVP_WATER_DAMAGE_REDUCE = 35,
          PVP_WATER_PERCENT_DAMAGE_REDUCE = 36,
          WIND_DAMAGE_REDUCE = 37,
          WIND_PERCENT_DAMAGE_REDUCE = 38,
          PVP_WIND_DAMAGE_REDUCE = 39,
          PVP_WIND_PERCENT_DAMAGE_REDUCE = 40,
          FIRE_DAMAGE_REDUCE = 41,
          FIRE_PERCENT_DAMAGE_REDUCE = 42,
          PVP_FIRE_DAMAGE_REDUCE = 43,
          PVP_FIRE_PERCENT_DAMAGE_REDUCE = 44;

	public static function isValidValue($value, $strict = true, $returnConstantName = false)
    {
    	foreach (self::getConstants() as $constant => $constantValue)
    		if ((is_array($constantValue) && in_array($value, $constantValue, $strict)) || ($strict && $constantValue === $value) || (!$strict && $constantValue == $value))
    			return $returnConstantName ? $constant : true;
 
    	return false;
    }

    public static function toString($value, $strict = true)
    {
        if (($constantName = self::isValidValue($value, $strict, $returnConstantName = true)))
            return $constantName;

        return false;
    }
}