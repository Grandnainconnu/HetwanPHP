<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-26 15:35:32
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-18 18:47:20
 */

namespace Hetwan\Helper\Player\Breed;

use Hetwan\Network\Game\Protocol\Enum\ItemEffectEnum;


class BreedHelper
{
	/**
	 * @var array
	 */
	private static $breeds = [];

	private static function loadBreeds()
	{
		$directory = realpath(dirname(__FILE__));

		foreach (scandir($directory) as $breedFile)
		{
			if (pathinfo($breedFile)['extension'] != 'xml')
				continue;

			$breedFile = $directory . '/' . $breedFile;
			$breed = ['name' => substr(basename($breedFile), 0, -4)];

			$XMLReader = new \XMLReader();
			$XMLReader->open($breedFile);

			while ($XMLReader->read())
			{
				static $lastCharacteristicId = null;

				if ($XMLReader->nodeType == \XMLReader::ELEMENT)
					switch ($XMLReader->name)
					{
						case 'breed':
							$breed['id'] = $XMLReader->getAttribute('id');
							$breed['startActionPoints'] = $XMLReader->getAttribute('startActionPoints');
							$breed['startMovementPoints'] = $XMLReader->getAttribute('startMovementPoints');
							$breed['startLifePoints'] = $XMLReader->getAttribute('startLife');
							$breed['startProspection'] = $XMLReader->getAttribute('startProspection');
							$breed['startMapId'] = $XMLReader->getAttribute('startMapId');
							$breed['startCellId'] = $XMLReader->getAttribute('startCellId');

							break;
						case 'levels':
							$lastCharacteristicId = $characteristicId = strtolower($XMLReader->getAttribute('type'));

							if (!isset($breed['characteristics']))
								$breed['characteristics'] = [$characteristicId => []];
							else
								$breed['characteristics'][$characteristicId] = [];

							break;
						case 'level':
							$range = explode('..', $XMLReader->getAttribute('range'));

							if (empty($range[1]))
								$range[1] = null;

							$characteristicRange = [
								'range' => $range,
								'bonus' => $XMLReader->getAttribute('bonus'),
								'cost' => $XMLReader->getAttribute('cost')
							];

							$breed['characteristics'][$lastCharacteristicId][] = $characteristicRange;

							break;
					}
			}

			foreach ($breed['characteristics'] as $k => $_)
				usort($breed['characteristics'][$k], function ($a, $b)
				{
					return (intval($a['range'][0]) > intval($b['range'][0]));
				});

			$XMLReader->close();

			self::$breeds[$breed['id']] = $breed;
		}
	}

	public static function getBreedFromId(int $breedId)
	{
		if (!count(self::$breeds))
    		self::loadBreeds();

		if (isset(self::$breeds[$breedId]))
			return self::$breeds[$breedId];
	}

	public static function getBreedFromName($breedName)
	{
		if (!count(self::$breeds))
    		self::loadBreeds();

		foreach (self::$breeds as $breed)
			if ($breed['name'] == $breedName)
				return $breed;
	}
}