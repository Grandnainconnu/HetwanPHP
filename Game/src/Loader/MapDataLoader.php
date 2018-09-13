<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-27 16:22:57
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 19:54:15
 */

namespace Hetwan\Loader;

use Hetwan\Entity\Game\MapDataEntity;


final class MapDataLoader extends \Hetwan\Loader\Base\Loader
{
	/**
	 * @var string
	 */
	protected $entity = MapDataEntity::class;

	/**
	 * @var bool
	 */
	protected $loadAll = true;
}