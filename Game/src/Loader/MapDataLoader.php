<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-27 16:22:57
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 19:54:15
 */

namespace Hetwan\Loader;


final class MapDataLoader extends AbstractGameLoader
{
	protected static $entity = '\Hetwan\Entity\Game\MapData';

	/**
	 * @var array
	 */
	protected static $values;

	public function loadAll()
	{
		;
	}

	public static function getMapWithId(int $mapId)
	{
		if (!isset(self::$values[$mapId]) && ($map = self::$entityManager->getRepository(self::$entity)->findOneById($mapId)) == null)
			return null;
		elseif (!isset(self::$values[$mapId]) && $map)
			self::$values[$mapId] = $map;

		return self::$values[$mapId];
	}

	public static function getMapWithPosition(int $x, int $y)
	{
		if (($map = self::$entityManager->getRepository(self::$entity)->findOneBy(['x' => $x, 'y' => $y])) == null)
			return null;

		return self::getMapWithId($map->getId());
	}

	public static function getPlayersInMap(int $mapId, array $exceptId = [])
	{
		if (self::getMapWithId($mapId) == null)
			return [];

		$players = self::$values[$mapId]->getPlayers();

		foreach ($players as $k => $player)
			if (in_array($player->getId(), $exceptId))
				unset($players[$k]);

		return $players;
	}

	public static function addPlayerInMap(int $mapId, $player)
	{
		if (self::getMapWithId($mapId) == null)
			return;

		self::$values[$mapId]->addPlayer($player);
	}

	public static function removePlayerInMap(int $mapId, $player)
	{
		if (self::getMapWithId($mapId) == null)
			return;

		self::$values[$mapId]->removePlayer($player);
	}
}