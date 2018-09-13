<?php

namespace Hetwan\Network\Game\Handler;

use Hetwan\Helper\Characteristic\CharacteristicHelper;
use Hetwan\Network\Game\Base\Handler\HandlerTrait;
use Hetwan\Network\Game\Protocol\Enum\CharacteristicTypeEnum;
use Hetwan\Network\Game\Protocol\Formatter\{
    GameMessageFormatter,
    ItemMessageFormatter,
    ApproachMessageFormatter
};


class ApproachHandler extends \Hetwan\Network\Base\Handler\Handler
{
	use HandlerTrait;

    /**
     * @Inject
     * @var \Hetwan\Helper\ExperienceDataHelper
     */
    private $experienceDataHelper;

	public function handle(string $data) : bool
	{
		switch (substr($data, 0, 1)) {
			case 'B':
				$this->boostPlayerCharacteristic(substr($data, 1));

				break;
			default:
                $this->logger->debug('Unable to handle approach packet: ' . $data . PHP_EOL);

				break;
		}

		return true;
	}

	private function boostPlayerCharacteristic(string $data) : void
	{
		if (CharacteristicHelper::upgradePlayerCharacteristic(strtolower(CharacteristicTypeEnum::toString(intval($data) - 5)), $this->getPlayer()))  {
            $this->send(GameMessageFormatter::playerStatisticsMessage(
                $this->getPlayer(),
                $this->experienceDataHelper->getWithLevel($this->getPlayer()->getLevel()))
            );
			$this->send(ItemMessageFormatter::inventoryStatsMessage(
				$this->getPlayer()->getCharacteristics()->getCharacteristic('pods')->getCurrent(),
				$this->getPlayer()->getCharacteristics()->getCharacteristic('pods')->getTotal()
			));
		}
		else {
            $this->send(ApproachMessageFormatter::boostCharacteristicErrorMessage());
        }
	}
}