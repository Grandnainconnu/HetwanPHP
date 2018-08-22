<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-23 23:29:06
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-27 00:53:04
 */

namespace Hetwan\Helper\Console;


trait ConsoleMessageTrait
{
	public function standardMessage($message, $type = 0)
	{
		return [$message, $type];
	}

	public function errorMessage($message)
	{
		return $this->standardMessage($message, 1);
	}

	public function successMessage($message)
	{
		return $this->standardMessage($message, 2);
	}
}