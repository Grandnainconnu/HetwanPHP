<?php

/**
 * @Author: jean
 * @Date:   2017-09-12 09:22:32
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-18 14:47:32
 */

namespace Hetwan\Loader;

use Hetwan\Entity\Server as ServerEntity;


final class Server extends \Hetwan\Loader\Base\Loader
{
	/**
	 * @var string
	 */
	protected $entity = ServerEntity::class;
}