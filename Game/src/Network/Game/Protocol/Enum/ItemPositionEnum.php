<?php

namespace Hetwan\Network\Game\Protocol\Enum;


class ItemPositionEnum extends AbstractEnum
{
	const INVENTORY 	= -1,
		  AMULET 		= 0,
		  WEAPON 		= 1,
		  RING_ONE 		= 2,
		  BELT      	= 3,
		  RING_TWO 		= 4,
		  BOOTS 		= 5,
		  CAP 			= 6,
		  MANTLE 		= 7,
		  ANIMAL 		= 8,
		  DOFUS_ONE 	= 9,
		  DOFUS_TWO 	= 10,
		  DOFUS_THREE 	= 11,
		  DOFUS_FOUR 	= 12,
		  DOFUS_FIVE 	= 13,
		  DOFUS_SIX 	= 14,
		  SHIELD 		= 15,
		  MOUNT 		= 16,
	      BAR_1         = 23,
          BAR_2         = 24,
          BAR_3         = 25,
          BAR_4         = 26,
          BAR_5         = 27,
          BAR_6         = 28,
          BAR_7         = 29,
          BAR_8         = 30,
          BAR_9         = 31,
          BAR_10        = 32,
          BAR_11        = 33,
          BAR_12        = 34,
          BAR_13        = 35,
          BAR_14        = 36,

          ACCESSORY     = [
                            self::CAP,
                            self::MANTLE,
                            self::ANIMAL,
                            self::SHIELD
                        ],
          EQUPMENT      = [
                            self::AMULET,
                            self::WEAPON,
                            self::RING_ONE,
                            self::BELT,
                            self::RING_TWO,
                            self::BOOTS,
                            self::CAP,
                            self::MANTLE,
                            self::ANIMAL,
                            self::DOFUS_ONE,
                            self::DOFUS_TWO,
                            self::DOFUS_THREE,
                            self::DOFUS_FOUR,
                            self::DOFUS_FIVE,
                            self::DOFUS_SIX,
                            self::SHIELD
                        ];
}