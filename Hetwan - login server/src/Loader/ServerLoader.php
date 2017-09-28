<?php

/**
 * @Author: jean
 * @Date:   2017-09-12 09:22:32
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-18 14:47:32
 */

namespace Hetwan\Loader;


final class ServerLoader extends AbstractLoader
{
	protected $entity = '\Hetwan\Entity\Server';

	public static function getServers()
	{
		return self::$values;
	}

	public static function findByKey($key)
	{
		foreach (self::$values as $server)
			if ($server->getKey() == $key)
				return $server;
	}

	public static function findById($id)
	{
		foreach (self::$values as $server)
			if ($server->getId() == $id)
				return $server;
	}
}