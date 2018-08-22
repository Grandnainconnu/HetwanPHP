<?php

/**
 * @Author: jeanw
 * @Date:   2017-11-03 23:26:04
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-31 13:53:09
 */

namespace Hetwan\Helper\Condition;

use Hetwan\Helper\AbstractHelper;

use Hetwan\Network\Game\Protocol\Enum\ItemPositionEnum;


class ConditionHelper extends AbstractHelper
{
    public static function playerFillItemConditions(string $conditions, $player)
    {
		$conditions = preg_replace(['/\~/', '/([A-Z]+)/'], ['=', '\$${1}'], $conditions);

        if (!$conditions)
            return true;

		$executor = new \NXP\MathExecutor();

		$executor
            ->addOperator('Hetwan\Helper\Condition\Operator\SuperiorToken') // I
		    ->addOperator('Hetwan\Helper\Condition\Operator\InferiorToken') // FUCKING
			->addOperator('Hetwan\Helper\Condition\Operator\AndToken') // LOVE
			->addOperator('Hetwan\Helper\Condition\Operator\OrToken') // THIS
			->addOperator('Hetwan\Helper\Condition\Operator\EqualToken') // FUCKING
			->addOperator('Hetwan\Helper\Condition\Operator\DifferentToken') // LIBRARY
            ->setVars([
        		'CI' => $player->getCharacteristics()->getCharacteristic('intelligence')->getTotal(), 
        		'CV' => $player->getCharacteristics()->getCharacteristic('vitality')->getTotal(),
        		'CA' => $player->getCharacteristics()->getCharacteristic('agility')->getTotal(),
        		'CW' => $player->getCharacteristics()->getCharacteristic('wisdom')->getTotal(),
        		'CC' => $player->getCharacteristics()->getCharacteristic('chance')->getTotal(),
        		'CS' => $player->getCharacteristics()->getCharacteristic('strength')->getTotal(),
        		'Ci' => $player->getCharacteristics()->getCharacteristic('intelligence')->getBase(),
        		'Cs' => $player->getCharacteristics()->getCharacteristic('strength')->getBase(),
        		'Cv' => $player->getCharacteristics()->getCharacteristic('vitality')->getBase(),
        		'Ca' => $player->getCharacteristics()->getCharacteristic('agility')->getBase(),
        		'Cw' => $player->getCharacteristics()->getCharacteristic('wisdom')->getBase(),
        		'Cc' => $player->getCharacteristics()->getCharacteristic('chance')->getBase(),
        		'Ps' => $player->getFaction(),
        		'PL' => $player->getLevel(),
        		'PK' => $player->getKamas(),
        	    'PG' => $player->getBreed(),
        		'PS' => $player->getGender(),
        		'PZ' => $player->getAccount()->getSubscriptionTimeLeft() > 0 ? 1 : 0,
        		'PX' => $player->getAccount()->getGmLevel(),
        		'PB' => \Hetwan\Loader\MapDataLoader::getMapWithId($player->getMapId())->getSubAreaId(),
        		'SI' => $player->getMapId(),
        		'PW' => $player->getCharacteristics()->getCharacteristic('pods')->getTotal(),
        		'MiS' => $player->getId()
            ]);

		return $executor->execute($conditions);
	}
}