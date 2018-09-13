<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-28 21:18:35
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-30 19:02:07
 */

namespace Hetwan\Helper\Characteristic\Base;


class Characteristic
{
	/**
	 * @var string
	 */
	protected $characteristicId;
	
	/**
	 * @var int
	 */
	protected $base;
	
	/**
	 * @var int
	 */
	protected $bonus;

	/**
	 * @var int
	 */
	protected $gift;

	/**
	 * @var int
	 */
	protected $context;

	public function __construct(string $characteristicId, int $base = 0, int $bonus = 0, int $gift = 0, int $context = 0)
	{
		$this->characteristicId = $characteristicId;
		$this->base = $base;
		$this->bonus = $bonus;
		$this->gift = $gift;
		$this->context = $context;
	}

	public function setBase(int $base)
	{
		$this->base = $base;

		return $this;
	}

	public function setBonus(int $bonus)
	{
		$this->bonus = $bonus;

		return $this;
	}

	public function getCharacteristicId()
	{
		return $this->characteristicId;
	}

	public function getBase() : int
	{
		return $this->base;
	}


	public function getBonus() : int
	{
		return $this->bonus;
	}

	public function getGift() : int
	{
		return $this->gift;
	}

	public function getContext() : int
	{
		return $this->context;
	}

	public function getTotal() : int
	{
		return $this->getBase() + $this->getBonus() + $this->getGift() + $this->getContext();
	}
}