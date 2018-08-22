<?php

/**
 * @Author: jeanw
 * @Date:   2017-11-01 22:08:50
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-11-01 22:11:20
 */

namespace Hetwan\Network\Game\Protocol\Enum;


class OrientationEnum extends AbstractEnum
{
	const EAST = 0,
		  SOUTH_EAST = 1,
    	  SOUTH = 2,
          SOUTH_WEST = 3,
          WEST = 4,
          NORTH_WEST = 5,
          NORTH = 6,
          NORTH_EAST = 7;
}