<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-26 00:54:46
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-31 14:24:16
 */

namespace Hetwan\Helper;

use Hetwan\Network\Game\Protocol\Enum\ItemEffectEnum;


class ItemEffectHelper
{
	public static function generateEffectsFromString($effects, $perfectEffects)
	{
		$effects = self::getEffectsFromString($effects);

		foreach ($effects as $k => $effect)
			if (is_array($effect))
				$effects[$k] = $perfectEffects == true ? $effect[1] : rand($effect[0], $effect[1]);

		return $effects;
	}

	public static function getEffectsFromString($effects)
	{
		$parseEffects = [];

		if (null != $effects)
			foreach (explode(',', $effects) as $effect)
			{
				$parsedEffect = explode('#', $effect);

		        $effectId = hexdec($parsedEffect[0]);
		        $minimumValue = hexdec($parsedEffect[1]);
		        $maximumValue = isset($parsedEffect[2]) ? hexdec($parsedEffect[2]) : 0;

		        if (ItemEffectEnum::isValidValue($effectId))
		        {
		        	$effectName = ItemEffectEnum::toString($effectId);

			        if (!$maximumValue)
			        	$parseEffects[$effectName] = $minimumValue;
			        else
		    	    	$parseEffects[$effectName] = [$minimumValue, $maximumValue];
				}
			}

		return $parseEffects;
	}

	public static function toString(array $effects)
	{
		$stringEffects = [];

		foreach ($effects as $effectId => $effect)
		{
			$effectId = dechex(is_array(($id = ItemEffectEnum::fromString($effectId))) ? $id[0] : $id);
			$effectValue = dechex($effect);

			$stringEffects[] = $effectId . '#' . $effectValue;
		}

		return implode(',', $stringEffects);
	}
}