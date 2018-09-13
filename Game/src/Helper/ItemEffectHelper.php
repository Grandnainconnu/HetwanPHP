<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-26 00:54:46
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-31 14:24:16
 */

namespace Hetwan\Helper;

use Hetwan\Network\Game\Protocol\Enum\ItemEffectEnum;


final class ItemEffectHelper
{
	public static function generateFromString(?string $effects, bool $perfectEffects) : array
	{
	    if ($effects === null) {
	        return [];
        }

		$effects = self::getFromString($effects);

		foreach ($effects as $k => $effect) {
			if (is_array($effect)) {
				$effects[$k] = $perfectEffects == true ? $effect[1] : rand($effect[0], $effect[1]);
			}
		}

		return $effects;
	}

	public static function getFromString(string $effects) : array
	{
		$parseEffects = [];

		if ($effects !== null) {
			foreach (explode(',', $effects) as $effect) {
				$parsedEffect = explode('#', $effect);

		        $effectId = hexdec($parsedEffect[0]);
		        $minimumValue = isset($parsedEffect[1]) ? hexdec($parsedEffect[1]) : 0;
		        $maximumValue = isset($parsedEffect[2]) ? hexdec($parsedEffect[2]) : 0;

		        if (ItemEffectEnum::isValidValue($effectId)) {
		        	$effectName = ItemEffectEnum::toString($effectId);

			        if (!$maximumValue) {
						$parseEffects[$effectName] = $minimumValue;
					} else {
						$parseEffects[$effectName] = [$minimumValue, $maximumValue];
					}
				}
			}
		}

		return $parseEffects;
	}

	public static function toString(array $effects) : string
	{
		$stringEffects = [];

		foreach ($effects as $effectId => $effect) {
			$effectId = dechex(is_array(($id = ItemEffectEnum::fromString($effectId))) ? $id[0] : $id);
			$effectValue = dechex($effect);

			$stringEffects[] = $effectId . '#' . $effectValue;
		}

		return implode(',', $stringEffects);
	}

	public static function getFromItems(iterable $items) : array
    {
        $itemsBonus = [];

        foreach ($items as $item) {
            $effects = self::getFromString($item->getEffects());

            foreach ($effects as $effectId => $effect) {
                if (isset($equipedItemsBonus[$effectId])) {
                    $itemsBonus[$effectId] += $effect;
                } else {
                    $itemsBonus[$effectId] = $effect;
                }
            }

            unset($effects);
        }

        return $itemsBonus;
    }
}