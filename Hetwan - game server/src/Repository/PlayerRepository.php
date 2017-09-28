<?php

/**
 * @Author: jean
 * @Date:   2017-09-18 13:48:51
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-18 13:56:27
 */

namespace Hetwan\Repository;

use Doctrine\ORM\EntityRepository;


class PlayerRepository extends EntityRepository
{
	public function countByNameCaseInsensitive($name)
	{
       	$query = $this->getEntityManager()
            		  ->createQueryBuilder()
            		  ->select('COUNT(p)')
			          ->where('upper(p.name) = upper(:name)')
			          ->from('\Hetwan\Entity\Login\Player', 'p')
			          ->setParameter('name', $name);

		return $query->getQuery()->getSingleScalarResult();
	}
}