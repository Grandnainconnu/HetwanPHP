<?php

/**
 * @Author: jean
 * @Date:   2017-09-17 21:29:33
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-22 18:54:40
 */

namespace Hetwan\Entity\Game;

use Hetwan\Entity\AbstractEntity;


abstract class AbstractGameEntity extends AbstractEntity
{
	protected function getEntityManager()
	{
		return \App\AppKernel::getContainer()->get('database')->getGameEntityManager();
	}
}