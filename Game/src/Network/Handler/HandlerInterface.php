<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 14:01:21
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 13:03:03
 */

namespace Hetwan\Network\Handler;


interface HandlerInterface
{
	const COMPLETED = 0;
	const FAILED = 1;

	public function 	initialize();
	public function 	handle($data);
	public function 	onClose();
}