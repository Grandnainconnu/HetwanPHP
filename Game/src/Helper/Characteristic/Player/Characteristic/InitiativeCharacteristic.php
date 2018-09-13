<?php

namespace Hetwan\Helper\Characteristic\Player\Characteristic;


final class InitiativeCharacteristic extends \Hetwan\Helper\Characteristic\Base\Characteristic
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
        return ((
                $this->player->getCharacteristics()->getCharacteristic('chance')->getTotal() +
                $this->player->getCharacteristics()->getCharacteristic('intelligence')->getTotal() +
                $this->player->getCharacteristics()->getCharacteristic('strength')->getTotal() +
                $this->player->getCharacteristics()->getCharacteristic('agility')->getTotal()
            )
            *
            (
                $this->player->getLifePoints() /
                $this->player->getMaximumLifePoints()
            )
        );
    }
}