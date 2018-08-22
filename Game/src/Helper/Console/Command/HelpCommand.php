<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-23 18:21:18
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-27 00:59:20
 */

namespace Hetwan\Helper\Console\Command;

use Hetwan\Helper\Console\ConsoleHelper;


class HelpCommand extends AbstractCommand
{
	public function __construct()
	{
		$this->name = 'help';
		$this->description = 'Display help.';
		$this->arguments = [
			new CommandArgument('command', 'Command name', CommandArgument::STRING, CommandArgument::NO_FILTER, false),
		];
	}

	public function execute($arguments, $_)
	{
		$commandDescription = function ($command) {
			return sprintf('- %s: %s', $command->getName(), $command->getDescription());
		};

		$commandArguments = function ($arguments, $onlyNames = true) {
			$commandArgumentsRepr = [];

			foreach ($arguments as $argument)
				if ($onlyNames)
					$commandArgumentsRepr[] = !$argument->isRequired() ? sprintf('[%s]', $argument->getName()) : $argument->getName();
				else
					$commandArgumentsRepr[] = sprintf('- %s (%s)', $argument->getName(), $argument->getDescription());

			return implode($onlyNames ? " " : "\n", $commandArgumentsRepr);
		};

		if (isset($arguments[0]) && ($command = ConsoleHelper::getCommand($arguments[0])))
			return $this->standardMessage(sprintf("Usage: %s %s\n%s", $command->getName(), $commandArguments($command->getArguments()), $commandArguments($command->getArguments(), false)));
		else
		{
			$commandsRepr = [];
			
			foreach (ConsoleHelper::getCommands() as $command)
				$commandsRepr[] = $commandDescription($command);

			return $this->standardMessage("Help:\n" . implode("\n", $commandsRepr));
		}
	}
}