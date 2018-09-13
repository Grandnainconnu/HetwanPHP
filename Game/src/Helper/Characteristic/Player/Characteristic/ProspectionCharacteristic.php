<?php

namespace Hetwan\Helper\Characteristic\Player\Characteristic;

use Helper\Helper\Player\Breed\BreedHelper;


final class ProspectionCharacteristic extends \Hetwan\Helper\Characteristic\Base\Characteristic
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
        return ($this->player->getCharacteristics()->getCharacteristic('chance')->getTotal() / 10) + $this->base;
    }
}