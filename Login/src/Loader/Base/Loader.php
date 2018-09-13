<?php

/**
 * @Author: jean
 * @Date:   2017-09-13 11:08:43
 * @Last Modified by:   Jean Walrave
 * @Last Modified time: 2018-04-11 16:22:14
 */

namespace Hetwan\Loader\Base;


abstract class Loader
{
	/**
	 * @var \Hetwan\Core\EntityManager 
	 */
	protected $entityManager;

	/**
	 * @var string
	 */
	protected $emName = 'default';

	/**
	 * @var string
	 */
	protected $entity;

	/**
	 * @var bool
	 */
	protected $loadAll = true;

	/**
	 * @var array
	 */
	protected $values = [];

	public function __construct(\Hetwan\Core\EntityManager $em)
	{
		$this->entityManager = $em;

		$this->initialize();
	}

	public function initialize() : void
	{
		if ($this->loadAll) {
			$this->loadAll();
		}
	}

	public function loadAll() : void
	{
		$this->values = $this->entityManager->get($this->emName)
										  	->getRepository($this->entity)
										  	->findAll();
	}

	public function getBy(array $filters, $assertCount = false, $first = false)
	{
		$toReturn = [];

		foreach ($this->values as $value) {
			if ($first and count($toReturn) > 0) {
				break;
			}

			$isGood = true;

			foreach ($filters as $filter => $val) {
				if (call_user_func_array([$value, 'get' . ucfirst($filter)], []) != $val) {
					$isGood = false;

					break;
				}
			}

			if ($isGood) {
				$toReturn[] = $value;
			}
		}

		if ($assertCount !== false and count($toReturn) > $assertCount) {
			throw new Exception("More than {$assertCount} found !");
		}

		return (($first and !count($toReturn)) ? null : (($first) ? $toReturn[0] : $toReturn));
	}

	public function &getValues() : array
	{
		return $this->values;
	}
}