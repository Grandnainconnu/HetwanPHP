<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-24 18:26:41
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 19:10:23
 */

namespace Hetwan\Loader;


final class SubAreaDataLoader extends AbstractGameLoader
{
	protected static $entity = '\Hetwan\Entity\Game\SubAreaData';

	/**
	 * @var array
	 */
	protected static $values;

	public function loadAll()
	{
		self::$values = self::$entityManager->getRepository(self::$entity)->findAll();
	}

	public static function getSubAreasData()
	{
		return self::$values;
	}
}