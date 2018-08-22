<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-23 18:24:55
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-27 00:55:13
 */

namespace Hetwan\Helper\Console\Command;


class CommandArgument
{
	/*
	 * Argument types
	 */
	const STRING = string,
		  INTEGER = int,
		  BOOLEAN = bool,
		  FLOAT = float;

	/*
	 * Argument filters
	 */
	const NO_FILTER = 0,
		  FILTER_COMMA = 1;

	/*
	 * Argument name
	 *
	 * @var string
	 */
	private $name;

	/*
	 * Argument description
	 *
	 * @var string
	 */
	private $description;

	/*
	 * Argument type
	 * 
	 * @var mixed
	 */
	private $type;

	/*
	 * Argument filter
	 * 
	 * @var int
	 */
	private $filter;

	/*
	 * Argument is mandatory
	 *
	 * @var boolean
	 */
	private $isRequired;

	public function __construct($name, $description, $type = CommandArgument::STRING, $filter = CommandArgument::NO_FILTER, $isRequired = true)
	{
		$this->name = $name;
		$this->description = $description;
		$this->type = $type;
		$this->filter = $filter;
		$this->isRequired = $isRequired;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function isRequired()
	{
		return $this->isRequired;
	}

	public function getValue($input)
	{
		if (settype($input, $this->type))
		{
			if ($this->filter != CommandArgument::NO_FILTER)
				switch ($this->filter)
				{
					case CommandArgument::FILTER_COMMA:
						$input = array_filter(explode(',', $input));

						break;
				}

			return $input;
		}
	}
}