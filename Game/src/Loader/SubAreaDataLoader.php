<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-24 18:26:41
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 19:10:23
 */

namespace Hetwan\Loader;

use Hetwan\Entity\Game\SubAreaDataEntity;


final class SubAreaDataLoader extends \Hetwan\Loader\Base\Loader
{
	/**
	 * @var string
	 */
	protected $entity = SubAreaDataEntity::class;

	/**
	 * @var bool
	 */
	protected $loadAll = true;
}