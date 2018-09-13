<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-23 17:57:32
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-27 01:03:53
 */

namespace Hetwan\Helper\Console\Command\Base;

use Hetwan\Helper\Console\ConsoleMessageTrait;


abstract class Command implements \Hetwan\Helper\Console\Command\Base\CommandInterface
{
	use ConsoleMessageTrait;

	/**
	 * Command name
	 *
	 * @var string
	 */
	protected $name;

	/**
	 * Command description
	 *
	 * @var string
	 */
	protected $description;
	
	/**
	 * Command parameters
	 *
	 * @var array
	 */
	protected $arguments = [];

	public function prepare(array &$arguments)
	{
		$requiredArgumentsCount = 0;

		foreach ($this->arguments as $argument) {
			if ($argument->isRequired() === true) {
				++$requiredArgumentsCount;
			}
		}

		if ($requiredArgumentsCount > count($arguments)) {
			return $this->errorMessage('Command ' . $this->name . ' require at least ' . $requiredArgumentsCount . ' arguments.');
		}

		foreach ($this->arguments as $index => $argument) {
			if (count($arguments) > $index and ($arguments[$index] = $argument->getValue($arguments[$index])) === null) {
				return $this->errorMessage('Wrong argument ' . $argument->getName() . '.');
			}
		}

		return true;
	}

	public function getName() : string
	{
		return $this->name;
	}

	public function getDescription() : string
	{
		return $this->description;
	}

	public function getArguments() : array
	{
		return $this->arguments;
	}
}