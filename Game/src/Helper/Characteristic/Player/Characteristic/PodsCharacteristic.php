<?php

namespace Hetwan\Helper\Characteristic\Player\Characteristic;

use Hetwan\Helper\Player\PlayerHelper;


final class PodsCharacteristic extends \Hetwan\Helper\Characteristic\Base\Characteristic
{
    /**
     * @var \Hetwan\Entity\Game\PlayerEntity
     */
    private $player;

    public function __construct(\Hetwan\Helper\Characteristic\Base\Characteristic $characteristic, \Hetwan\Entity\Game\PlayerEntity &$player)
    {
        parent::__construct(
            $characteristic->getCharacteristicId(),
            $characteristic->getBase(),
            $characteristic->getBonus(),
            $characteristic->getGift(),
            $characteristic->getContext()
        );

        $this->player = $player;
    }

    public function getBase() : int
    {
        return 1000 + $this->player->getCharacteristics()->getCharacteristic('strength')->getTotal() * 5;
    }

    public function getCurrent() : int
    {
        return PlayerHelper::getTakenPods($this->player);
    }
}