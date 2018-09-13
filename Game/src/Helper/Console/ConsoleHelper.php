<?php

namespace Hetwan\Helper\Console;

use Hetwan\Helper\Console\Command\{AddItemCommand, HelpCommand, TeleportCommand};


final class ConsoleHelper
{
	use ConsoleMessageTrait;

    /**
     * @Inject
     * @var \DI\Container
     */
    private $container;

	/**
	 * @var array
	 */
	private $commands = [
        AddItemCommand::class,
        HelpCommand::class,
        TeleportCommand::class
    ];

	public function handle(array $arguments, int $playerId)
	{
	    static $commandsInitialized = false;

		$key = $arguments[0];

		if (empty($key)) {
			return $this->standardMessage('What ?');
		} elseif (!$commandsInitialized) {
		    foreach ($this->commands as $k => $command) {
                $this->commands[$k] = $this->container->get($command);
            }

            $commandsInitialized = true;
        }

		$arguments = array_slice($arguments, 1);

		foreach ($this->commands as $k => $command) {
			if ($key === $command->getName()) {
				if (is_array(($preparationResults = $command->prepare($arguments)))) {
					return $preparationResults;
				} else {
					return $command->execute($arguments, $playerId);
				}
			}
		}

		return $this->errorMessage('Unable to handle command ' . $key . '.');
	}

	public function getCommand(string $commandName) : ?\Hetwan\Helper\Console\Command\Base\CommandInterface
	{
		foreach ($this->commands as $command) {
			if ($command->getName() === $commandName) {
				return $command;
			}
		}

		return null;
	}

	public function getCommands() : array
	{
		return $this->commands;
	}
}