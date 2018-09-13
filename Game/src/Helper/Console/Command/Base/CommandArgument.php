<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-23 18:24:55
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-27 00:55:13
 */

namespace Hetwan\Helper\Console\Command\Base;


final class CommandArgument
{
	/**
	 * Argument types
	 * @var type
	 */
	const STRING = string,
		  INTEGER = int,
		  BOOLEAN = bool,
		  FLOAT = float;

	/**
	 * Argument filters
	 * @var int
	 */
	const NO_FILTER = 0,
		  FILTER_COMMA = 1;

	/**
	 * Argument name
	 *
	 * @var string
	 */
	private $name;

	/**
	 * Argument description
	 *
	 * @var string
	 */
	private $description;

	/**
	 * Argument type
	 * 
	 * @var mixed
	 */
	private $type;

	/**
	 * Argument filter
	 * 
	 * @var int
	 */
	private $filter;

	/**
	 * Argument is mandatory
	 *
	 * @var boolean
	 */
	private $isRequired;

	public function __construct(string $name, string $description, $type = CommandArgument::STRING, int $filter = CommandArgument::NO_FILTER, bool $isRequired = true)
	{
		$this->name = $name;
		$this->description = $description;
		$this->type = $type;
		$this->filter = $filter;
		$this->isRequired = $isRequired;
	}

	public function isRequired()
	{
		return $this->isRequired;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getDescription()
	{
		return $this->description;
	}

	public function getValue(string $input)
	{
		if (settype($input, $this->type)) {
			if ($this->filter !== CommandArgument::NO_FILTER) {
				switch ($this->filter) {
					case CommandArgument::FILTER_COMMA:
						$input = array_filter(explode(',', $input));

						break;
				}
			}

			return $input;
		}
	}
}