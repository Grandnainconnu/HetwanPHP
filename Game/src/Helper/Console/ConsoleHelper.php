<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-23 17:57:49
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-30 19:56:00
 */

namespace Hetwan\Helper\Console;


class ConsoleHelper
{
	use ConsoleMessageTrait;

	private static $commands;

	public function __construct()
	{
		self::$commands = [
			new Command\TeleportCommand,
			new Command\AddItemCommand,
			new Command\HelpCommand
		];
	}

	public function handle($arguments, $playerId)
	{
		$key = $arguments[0];

		if (empty($key))
			return $this->standardMessage(sprintf('What ?'));

		$arguments = array_slice($arguments, 1);

		foreach (self::$commands as $command)
			if ($key == $command->getName())
				if (is_array(($preparationResult = $command->prepare($arguments))))
					return $preparationResult;
				else
					return $command->execute($arguments, $playerId);

		return $this->errorMessage(sprintf('Unable to handle command \'%s\'.', $key));
	}

	public static function getCommand($commandName)
	{
		foreach (self::$commands as $command)
			if ($command->getName() == $commandName)
				return $command;
	}

	public static function getCommands()
	{
		return self::$commands;
	}
}