<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-24 14:42:27
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-24 14:55:52
 */

namespace Hetwan\Helper;


class ExperienceDataHelper extends AbstractHelper
{
	public static function getExperience($level)
	{
		return self::getGameEntityManager()
			->createQueryBuilder()
			->select('e.player')
			->from('\Hetwan\Entity\Game\ExperienceData', 'e')
			->where('e.level IN (:minLevel, :maxLevel)')
			->setParameter('minLevel', $level)
			->setParameter('maxLevel', $level + 1)
			->getQuery()
			->getResult();
	}
}