<?php

namespace Hetwan\Repository;

use Hetwan\Entity\Game\PlayerEntity;


final class PlayerRepository extends \Doctrine\ORM\EntityRepository
{
	public function countByNameCaseInsensitive(string $name) : int
	{
       	$query = $this->getEntityManager()
            		  ->createQueryBuilder()
            		  ->select('COUNT(p)')
			          ->where('upper(p.name) = upper(:name)')
			          ->from(PlayerEntity::class, 'p')
			          ->setParameter('name', $name);

		return $query->getQuery()->getSingleScalarResult();
	}
}