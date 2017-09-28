<?php

/**
 * @Author: jean
 * @Date:   2017-09-17 21:29:33
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 23:11:24
 */

namespace Hetwan\Entity;

abstract class AbstractEntity implements EntityInterface
{
	protected function getEntityManager()
	{
		return \App\AppKernel::getContainer()->get('database')->getEntityManager();
	}

	public function save()
	{
		$this->getEntityManager()->persist($this);
		$this->getEntityManager()->flush();

		return $this;
	}

	public function remove()
	{
		$this->getEntityManager()->remove($this);
		$this->getEntityManager()->flush();

		return $this;
	}

	public function refresh()
	{
		$this->getEntityManager()->refresh($this);

		return $this;
	}
}