<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 14:01:21
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 13:43:18
 */

namespace Hetwan\Network\Handler;


interface HandlerInterface
{
	const COMPLETED = 0;
	const FAILED = 1;

	public function initialize();
	public function send($data);
	public function handle($data);
}