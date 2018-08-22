<?php

/**
 * @Author: jeanw
 * @Date:   2017-12-23 15:57:20
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-23 16:03:07
 */

namespace Hetwan\Helper;


class ScriptedCellDataHelper extends AbstractHelper
{
	public static function getScriptedCell(int $mapId, int $cellId)
	{
		$scriptedCell = self::getGameEntityManager()
							->getRepository('\Hetwan\Entity\Game\ScriptedCellData')
							->findOneBy([
								'mapId' => $mapId, 
								'cellId' => $cellId
							]);

		return $scriptedCell;
	}

	public static function useScriptedCell($scriptedCell)
	{
		$scriptedCellActionArguments = explode(',', $scriptedCell->getActionArguments());

		return [
			'nextMapId' => $scriptedCellActionArguments[0], 
			'nextCellId' => $scriptedCellActionArguments[1]
		];
	}
}