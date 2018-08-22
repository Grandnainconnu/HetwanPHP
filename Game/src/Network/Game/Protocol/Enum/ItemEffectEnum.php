<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-26 00:05:20
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-18 18:08:25
 */

namespace Hetwan\Network\Game\Protocol\Enum;


class ItemEffectEnum extends AbstractEnum
{
	const UNKNOWN = -1;
	const HUNTING_WEAPON = 795;
	const TELEPORT_TO_LAST_SAVE_POINT = 600;
	const TELEPORT = 4;
	const PUSH_BACK = 5;
	const PUSH_FRONT = 6;
	const TRANSPOSE = 8;
	const MP_THEFT = 77;
	const LIFE_THEFT = 82;
	const AP_THEFT = 84;
	const ADD_EXPERIENCE = 605;
	const LIFE_WATER_DAMAGE = 85;
	const LIFE_EARTH_DAMAGE = 86;
	const LIFE_AIR_DAMAGE = 87;
	const LIFE_FIRE_DAMAGE = 88;
	const LIFE_NEUTRAL_DAMAGE = 89;
	const WATER_THEFT = 91;
	const EARTH_THEFT = 92;
	const AIR_THEFT = 93;
	const FIRE_THEFT = 94;
	const NEUTRAL_THEFT = 95;
	const WATER_DAMAGE = 96;
	const EARTH_DAMAGE = 97;
	const AIR_DAMAGE = 98;
	const FIRE_DAMAGE = 99;
	const NEUTRAL_DAMAGE = 100;
	const ADD_ARMOR = [105, 265];
	const ADD_RETURN_DAMAGE = 107;
	const HEAL = 108;
	const THROWER_DAMAGE = 109;
	const ADD_LIFE = 110;
	const ADD_AP = [111, 120];
	const ADD_DAMAGE = 112;
	const MULTIPLY_DAMAGE = 114;
	const ADD_AGILITY = 119;
	const ADD_CHANCE = 123;
	const ADD_PERCENT_DAMAGE = 138;
	const ADD_CRITICAL_DAMAGE = 115;
	const ADD_TRAP_DAMAGE = 225;
	const ADD_TRAP_PERCENT_DAMAGE = 220;
	const ADD_PHYSICAL_DAMAGE = 142;
	const ADD_MAGICAL_DAMAGE = 143;
	const ADD_CRITICAL_FAILURE = 122;
	const ADD_DODGE_AP = 160;
	const ADD_DODGE_MP = 161;
	const ADD_STRENGTH = 118;
	const ADD_INITIATIVE = 174;
	const ADD_INTELLIGENCE = 126;
	const ADD_SUMMON = 182;
	const ADD_MP = 128;
	const ADD_SP = 117;
	const ADD_PODS = 158;
	const ADD_PROSPECTION = 176;
	const ADD_WISDOM = 124;
	const ADD_CARE = 178;
	const ADD_ENERGY = 139;
	const ADD_VITALITY = 125;
	const SUB_AGILITY = 154;
	const SUB_CHANCE = 152;
	const SUB_DAMAGE = 164;
	const SUB_CRITICAL_DAMAGE = 171;
	const SUB_MAGICAL_DAMAGE = 172;
	const SUB_PHYSICAL_DAMAGE = 173;
	const SUB_DODGE_AP = 162;
	const SUB_DODGE_MP = 163;
	const SUB_STRENGTH = 157;
	const SUB_INITIATIVE = 175;
	const SUB_INTELLIGENCE = 155;
	const SUB_AP = 101;
	const SUB_MP = 127;
	const SUB_SP = 116;
	const SUB_PODS = 159;
	const SUB_PROSPECTION = 177;
	const SUB_WISDOM = 156;
	const SUB_CARE = 179;
	const SUB_VITALITY = 153;
	const SUMMON = 181;
	const ADD_PHYSICAL_DAMAGE_REDUCE = 183;
	const ADD_MAGICAL_DAMAGE_REDUCE = 184;
	const ADD_WATER_PERCENT_DAMAGE_REDUCE = 211;
	const ADD_EARTH_PERCENT_DAMAGE_REDUCE = 210;
	const ADD_AIR_PERCENT_DAMAGE_REDUCE = 212;
	const ADD_FIRE_PERCENT_DAMAGE_REDUCE = 213;
	const ADD_NEUTRAL_PERCENT_DAMAGE_REDUCE = 214;
	const ADD_PVP_WATER_PERCENT_DAMAGE_REDUCE = 251;
	const ADD_PVP_EARTH_PERCENT_DAMAGE_REDUCE = 250;
	const ADD_PVP_AIR_PERCENT_DAMAGE_REDUCE = 252;
	const ADD_PVP_FIRE_PERCENT_DAMAGE_REDUCE = 253;
	const ADD_PVP_NEUTRAL_PERCENT_DAMAGE_REDUCE = 254;
	const ADD_WATER_DAMAGE_REDUCE = 241;
	const ADD_EARTH_DAMAGE_REDUCE = 240;
	const ADD_AIR_DAMAGE_REDUCE = 242;
	const ADD_FIRE_DAMAGE_REDUCE = 243;
	const ADD_NEUTRAL_DAMAGE_REDUCE = 244;
	const ADD_PVP_WATER_DAMAGE_REDUCE = 261;
	const ADD_PVP_EARTH_DAMAGE_REDUCE = 260;
	const ADD_PVP_AIR_DAMAGE_REDUCE = 262;
	const ADD_PVP_FIRE_DAMAGE_REDUCE = 263;
	const ADD_PVP_NEUTRAL_DAMAGE_REDUCE = 264;
	const SUB_WATER_DAMAGE_REDUCE = 246;
	const SUB_EARTH_DAMAGE_REDUCE = 245;
	const SUB_AIR_DAMAGE_REDUCE = 247;
	const SUB_FIRE_DAMAGE_REDUCE = 248;
	const SUB_NEUTRAL_DAMAGE_REDUCE = 249;
	const SUB_PVP_WATER_PERCENT_DAMAGE_REDUCE = 255;
	const SUB_PVP_EARTH_PERCENT_DAMAGE_REDUCE = 256;
	const SUB_PVP_AIR_PERCENT_DAMAGE_REDUCE = 257;
	const SUB_PVP_FIRE_PERCENT_DAMAGE_REDUCE = 258;
	const SUB_PVP_NEUTRAL_PERCENT_DAMAGE_REDUCE = 259;
	const CARRY = 50;
	const THROW = 51;
	const CHANGE_SKIN = 149;
	const SPELL_BOOST = 293;
	const USE_TRAP = 400;
	const USE_GLYPH = 401;
	const DO_NOTHING = 666;
	const LIFE_DAMAGE = 672;
	const PUSH_FEAR = 783;
	const ADD_PUNISHMENT = 788;
	const ADD_STATE = 950;
	const LOST_STATE = 951;
	const INVISIBLE = 150;
	const DELETE_ALL_BONUS = 132;
	const ADD_SPELL = 604;
	const ADD_CHARACTERISTIC_POINT = 612;
	const ADD_SPELL_POINT = 613;
	const ADD_CHARACTERISTIC_FORCE = 607;
	const ADD_CHARACTERISTIC_WISDOM = 678;
	const ADD_CHARACTERISTIC_CHANCE = 608;
	const ADD_CHARACTERISTIC_AGILITY = 609;
	const ADD_CHARACTERISTIC_VITALITY = 610;
	const ADD_CHARACTERISTIC_INTELLIGENCE = 611;
	const ADD_PERCENT_MOUNT_CAPTURE_PROBABILITY = 706;

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