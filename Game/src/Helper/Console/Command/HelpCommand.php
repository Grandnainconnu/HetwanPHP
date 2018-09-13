<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-23 18:21:18
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-27 00:59:20
 */

namespace Hetwan\Helper\Console\Command;

use Hetwan\Helper\Console\Command\Base\CommandArgument;


final class HelpCommand extends \Hetwan\Helper\Console\Command\Base\Command
{
	/**
	 * @Inject
	 * @var \Hetwan\Helper\Console\ConsoleHelper
	 */
	private $consoleHelper;

	public function __construct()
	{
		$this->name = 'help';
		$this->description = 'Display help.';
		$this->arguments = [
			new CommandArgument('command', 'Command name', CommandArgument::STRING, CommandArgument::NO_FILTER, false),
		];
	}

	public function execute(array $arguments, int $playerId)
	{
		if (isset($arguments[0]) and ($command = $this->consoleHelper->getCommand($arguments[0]))) {
			return $this->standardMessage('Usage: ' . $command->getName() . ' ' . self::getFormattedCommandArguments($command->getArguments()) . PHP_EOL . self::getFormattedCommandArguments($command->getArguments(), false));
		} else {
			$commandsRepr = [];
			$commands = $this->consoleHelper->getCommands();

			foreach ($commands as $command) {
				$commandsRepr[] = '- ' . $command->getName() . ': ' . $command->getDescription();
			}

			unset($commands);

			return $this->standardMessage('Help:' . PHP_EOL . implode(PHP_EOL, $commandsRepr));
		}
	}

	private static function getFormattedCommandArguments(array $arguments, bool $onlyNames = true) : string
	{
		$commandArgumentsRepr = [];

		foreach ($arguments as $argument) {
			if ($onlyNames) {
				$commandArgumentsRepr[] = (!$argument->isRequired()) ? '[' . $argument->getName() . ']' : $argument->getName();
			} else {
				$commandArgumentsRepr[] = '- ' . $argument->getName() . ' (' . $argument->getDescription() . ')';
			}
		}

		return implode($onlyNames ? ' ' : PHP_EOL, $commandArgumentsRepr);
	}
}