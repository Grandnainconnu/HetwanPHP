<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-28 21:18:35
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-30 19:02:07
 */

namespace Hetwan\Helper\Characteristic;


class Characteristic
{
	protected $characteristicId,
			  $base,
			  $bonus,
			  $gift,
			  $context;

	public function __construct(string $characteristicId, $base = 0, $bonus = 0, $gift = 0, $context = 0)
	{
		$this->characteristicId = $characteristicId;
		$this->base = $base;
		$this->bonus = $bonus;
		$this->gift = $gift;
		$this->context = $context;
	}

	public function getCharacteristicId()
	{
		return $this->characteristicId;
	}

	public function setBase($base)
	{
		$this->base = $base;

		return $this;
	}

	public function getBase()
	{
		return (int) $this->base;
	}

	public function setBonus($bonus)
	{
		$this->bonus = $bonus;

		return $this;
	}

	public function getBonus()
	{
		return (int) $this->bonus;
	}

	public function getGift()
	{
		return (int) $this->gift;
	}

	public function getContext()
	{
		return (int) $this->context;
	}

	public function getTotal()
	{
		return $this->getBase() + $this->getBonus() + $this->getGift() + $this->getContext(); 
	}
}