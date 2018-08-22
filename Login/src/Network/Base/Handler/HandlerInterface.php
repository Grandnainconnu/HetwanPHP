<?php

/**
 * @Author: jean
 * @Date:   2017-09-05 14:01:21
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-13 18:10:11
 */

namespace Hetwan\Network\Base\Handler;


interface HandlerInterface
{
	public function initialize() : void;
	public function send($_) : void;
	public function handle(string $_) : bool;
}