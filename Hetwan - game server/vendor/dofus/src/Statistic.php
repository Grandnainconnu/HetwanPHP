<?php

/**
 * @Author: jean
 * @Date:   2017-09-21 18:26:15
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-22 13:09:01
 */

namespace Dofus;


final class Statistic
{
	const STATISTICS = [
		'unknown' => -1,
		'teleport' => 4,
		'pushBack' => 5,
		'pushFront' => 6,
		'transpose' => 8,
		'mpTheft' => 77,
		'lifeTheft' => 82,
		'apTheft' => 84,
		'lifeWaterDamage' => 85,
		'lifeEarthDamage' => 86,
		'lifeAirDamage' => 87,
		'lifeFireDamage' => 88,
		'lifeNeutralDamage' => 89,
		'waterTheft' => 91,
		'earthTheft' => 92,
		'airTheft' => 93,
		'fireTheft' => 94,
		'neutralTheft' => 95,
		'waterDamage' => 96,
		'earthDamage' => 97,
		'airDamage' => 98,
		'fireDamage' => 99,
		'neutralDamage' => 100,
		'addArmor' => [105, 265],
		'addReturnDamage' => 107,
		'heal' => 108,
		'throwerDamage' => 109,
		'addLife' => 110,
		'addAp' => [111, 120],
		'addDamage' => 112,
		'multiplyDamage' => 114,
		'addAgility' => 119,
		'addChance' => 123,
		'addPercentDamage' => 138,
		'addCriticalDamage' => 115,
		'addTrapDamage' => 225,
		'addTrapPercentDamage' => 220,
		'addPhysicDamage' => 142,
		'addMagicDamage' => 143,
		'addCriticalFailure' => 122,
		'addDodgePa' => 160,
		'addDodgePm' => 161,
		'addStrength' => 118,
		'addInitiative' => 174,
		'addIntelligence' => 126,
		'addInvocation' => 182,
		'addMp' => 128,
		'addSp' => 117,
		'addPods' => 158,
		'addProspecting' => 176,
		'addWisdom' => 124,
		'addCare' => 178,
		'addVitality' => 125,
		'subAgility' => 154,
		'subChance' => 152,
		'subDamage' => 164,
		'subCriticalDamage' => 171,
		'subMagicDamage' => 172,
		'subPhysicDamage' => 173,
		'subDodgeAp' => 162,
		'subDodgeMp' => 163,
		'subStrength' => 157,
		'subInitiative' => 175,
		'subIntelligence' => 155,
		'subAp' => 101,
		'subMp' => 127,
		'subSp' => 116,
		'subPods' => 159,
		'subProspecting' => 177,
		'subWisdom' => 156,
		'subCare' => 179,
		'subVitality' => 153,
		'invocation' => 181,
		'addPhysicDamageReduce' => 183,
		'addMagicDamageReduce' => 184,
		'addWaterPercentDamageReduce' => 211,
		'addEarthPercentDamageReduce' => 210,
		'addAirPercentDamageReduce' => 212,
		'addFirePercentDamageReduce' => 213,
		'addNeutralPercentDamageReduce' => 214,
		'addPvpWaterPercentDamageReduce' => 251,
		'addPvpEarthPercentDamageReduce' => 250,
		'addPvpAirPercentDamageReduce' => 252,
		'addPvpFirePercentDamageReduce' => 253,
		'addPvpNeutralPercentDamageReduce' => 254,
		'addWaterDamageReduce' => 241,
		'addEarthDamageReduce' => 240,
		'addAirDamageReduce' => 242,
		'addFireDamageReduce' => 243,
		'addNeutralDamageReduce' => 244,
		'addPvpWaterDamageReduce' => 261,
		'addPvpEarthDamageReduce' => 260,
		'addPvpAirDamageReduce' => 262,
		'addPvpFireDamageReduce' => 263,
		'addPvpNeutralDamageReduce' => 264,
		'subWaterDamageReduce' => 216,
		'subEarthDamageReduce' => 215,
		'subAirDamageReduce' => 217,
		'subFireDamageReduce' => 218,
		'subNeutralDamageReduce' => 219,
		'subPvpWaterPercentDamageReduce' => 255,
		'subPvpEarthPercentDamageReduce' => 256,
		'subPvpAirPercentDamageReduce' => 257,
		'subPvpFirePercentDamageReduce' => 258,
		'subPvpNeutralPercentDamageReduce' => 259,
		'subWaterDamageReduce' => 246,
		'subEarthDamageReduce' => 245,
		'subAirDamageReduce' => 247,
		'subFireDamageReduce' => 248,
		'subNeutralDamageReduce' => 249,
		'carry' => 50,
		'throw' => 51,
		'changeSkin' => 149,
		'spellBoost' => 293,
		'useTrap' => 400,
		'useGlyph' => 401,
		'doNothing' => 666,
		'lifeDamage' => 672,
		'pushFear' => 783,
		'addPunishment' => 788,
		'addState' => 950,
		'lostState' => 951,
		'invisible' => 150,
		'deleteAllBonus' => 132,
		'addSpell' => 604
	];

	/*
	AddCharactForce = 607,
	AddCharactSagesse = 678,
	AddCharactChance = 608,
	AddCharactAgilite = 609,
	AddCharactVitalite = 610,
	AddCharactIntelligence = 611,
	AddCharactPoint = 612,
	AddSpellPoint = 613,
	LastEat = 808,
	MountOwner = 995,
	LivingGfxId = 970,
	LivingMood = 971,
	LivingSkin = 972,
	LivingType = 973,
	LivingXp = 974,
	CanBeExchange = 983,
	*/

	private static function getStatisticNameWithId($id)
	{
		foreach (Statistic::STATISTICS as $caracteristicName => $caracteristicId)
			if (!is_array($caracteristicId) && $caracteristicId == $id)
				return $caracteristicName;
			elseif (is_array($caracteristicId) && in_array($id, $caracteristicId))
				return $caracteristicName;

		return $id;
	}

	public static function parse($stringStatistics)
	{
		$statistics = [];

		if (null != $stringStatistics)
			foreach (explode(',', $stringStatistics) as $statistic)
			{
				$parsedStatistic = explode('#', $statistic);

		        $statisticId = hexdec($parsedStatistic[0]);
		        $minusValue = hexdec($parsedStatistic[1]);
		        $maximumValue = isset($parsedStatistic[2]) ? hexdec($parsedStatistic[2]) : 0;

		        $caracteristicName = self::getStatisticNameWithId($statisticId);

		        if (!$maximumValue)
		        	$statistics[$caracteristicName] = $minusValue;
		        else
		        	$statistics[$caracteristicName] = [$minusValue, $maximumValue];
			}

		return $statistics;
	}
}