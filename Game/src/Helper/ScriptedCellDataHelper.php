<?php

namespace Hetwan\Helper;


final class ScriptedCellDataHelper
{
	public static function use(\Hetwan\Entity\Game\ScriptedCellDataEntity $scriptedCell) : array
	{
		list($nextMapId, $nextCellId) = explode(',', $scriptedCell->getActionArguments());

		return [
            (int)$nextMapId,
            (int)$nextCellId
        ];
	}
}