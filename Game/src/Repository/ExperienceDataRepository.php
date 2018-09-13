<?php

/**
 * @Author: jean
 * @Date:   2017-09-18 13:48:51
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-18 13:56:27
 */

namespace Hetwan\Repository;

use Hetwan\Entity\Game\ExperienceDataEntity;


final class ExperienceDataRepository extends \Doctrine\ORM\EntityRepository
{
	public function getExperienceData(int $level) : array
	{
		$toReturn = $this->getEntityManager()
                         ->createQueryBuilder()
                         ->select('e.player')
                         ->from(ExperienceDataEntity::class, 'e')
                         ->where('e.level IN (:minLevel, :maxLevel)')
                         ->setParameter('minLevel', $level)
                         ->setParameter('maxLevel', $level + 1)
                         ->getQuery()
                         ->getResult();

		if (($n = count($toReturn)) === 2) {
		    return $toReturn;
        } elseif ($n === 1) {
		    return [$toReturn[0], ['player' => -1]];
        } else {
		    return [['player' => -1], ['player' => -1]];
        }
	}
}