<?php

namespace Hetwan\Helper\Console;


trait ConsoleMessageTrait
{
	public function standardMessage(string $message, $type = 0) : array
	{
		return [$message, $type];
	}

	public function errorMessage(string $message) : array
	{
		return $this->standardMessage($message, 1);
	}

	public function successMessage(string $message) : array
	{
		return $this->standardMessage($message, 2);
	}
}