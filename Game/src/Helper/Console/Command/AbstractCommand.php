<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-23 17:57:32
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-27 01:03:53
 */

namespace Hetwan\Helper\Console\Command;


abstract class AbstractCommand
{
	use \Hetwan\Helper\Console\ConsoleMessageTrait;

	/*
	 * Command name
	 *
	 * @var string
	 */
	protected $name;

	/*
	 * Command description
	 *
	 * @var string
	 */
	protected $description;
	
	/*
	 * Command parameters
	 *
	 * @var \array
	 */
	protected $arguments = [];

	public function getName()
	{
		return $this->name;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getArguments()
	{
		return $this->arguments;
	}

	public function prepare(&$arguments)
	{
		// Test required arguments number
		$requiredArguments = 0;

		foreach ($this->arguments as $argument)
			if ($argument->isRequired() == true)
				++$requiredArguments;

		if ($requiredArguments > count($arguments))
			return $this->errorMessage(sprintf('Command \'%s\' require at least %d arguments.', $this->name, $requiredArguments));

		foreach ($this->arguments as $index => $argument)
			if (count($arguments) > $index && ($arguments[$index] = $argument->getValue($arguments[$index])) == null)
				return $this->errorMessage(sprintf('Wrong argument \'%s\'.', $argument->getName()));

		return true;
	}
}