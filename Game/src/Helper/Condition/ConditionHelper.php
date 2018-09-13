<?php

namespace Hetwan\Helper\Condition;

use NXP\MathExecutor;

use Hetwan\Helper\Condition\Operator\{
    SuperiorTokenOperator,
    InferiorTokenOperator,
    AndTokenOperator,
    OrTokenOperator,
    EqualTokenOperator,
    DifferentTokenOperator
};


final class ConditionHelper
{
	/**
	 * @Inject
	 * @var \Hetwan\Loader\MapDataLoader
	 */
	private $mapDataLoader;

    public function fill(string $conditions, \Hetwan\Entity\Game\PlayerEntity $player) : bool
    {
		$conditions = preg_replace(['/\~/', '/([A-Z]+)/'], ['=', '\$${1}'], $conditions);

        if (!$conditions) {
			return true;
		}

		$executor = new MathExecutor;
		$executor->addOperator(SuperiorTokenOperator::class) // I
		    	 ->addOperator(InferiorTokenOperator::class) // FUCKING
				 ->addOperator(AndTokenOperator::class) // LOVE
				 ->addOperator(OrTokenOperator::class) // THIS
				 ->addOperator(EqualTokenOperator::class) // FUCKING
				 ->addOperator(DifferentTokenOperator::class) // LIBRARY
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
					'PB' => $this->mapDataLoader->getBy(['id' => $player->getMapId()], false, true)->getSubAreaId() ?? -1,
					'SI' => $player->getMapId(),
					'PW' => $player->getCharacteristics()->getCharacteristic('pods')->getTotal(),
					'MiS' => $player->getId()
            	 ]);

		return $executor->execute($conditions);
	}
}