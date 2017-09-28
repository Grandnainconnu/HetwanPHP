<?php

/**
 * @Author: jean
 * @Date:   2017-09-17 21:29:33
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 23:01:38
 */

namespace Hetwan\Entity;


interface EntityInterface
{
	public function save();
	public function remove();
	public function refresh();
}