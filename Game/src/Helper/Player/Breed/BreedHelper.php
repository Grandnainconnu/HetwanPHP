<?php

namespace Hetwan\Helper\Player\Breed;

use XMLReader;


final class BreedHelper
{
	/**
	 * @var array
	 */
	private static $breeds = [];

	private static function loadBreeds()
	{
		$directory = realpath(dirname(__FILE__));

		foreach (scandir($directory) as $breedFile) {
			if (pathinfo($breedFile)['extension'] !== 'xml') {
				continue;
			}

			$breedFile = $directory . '/' . $breedFile;
			$breed = ['name' => substr(basename($breedFile), 0, -4)];

			$XMLReader = new XMLReader();
			$XMLReader->open($breedFile);

			while ($XMLReader->read()) {
				static $lastCharacteristicId = null;

				if ($XMLReader->nodeType == XMLReader::ELEMENT) {
					switch ($XMLReader->name) {
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

							if (!isset($breed['characteristics'])) {
								$breed['characteristics'] = [$characteristicId => []];
							} else { 
								$breed['characteristics'][$characteristicId] = [];
							}

							break;
						case 'level':
							$range = explode('..', $XMLReader->getAttribute('range'));

							if (empty($range[1])) {
								$range[1] = null;
							}

							$characteristicRange = [
								'range' => $range,
								'bonus' => $XMLReader->getAttribute('bonus'),
								'cost' => $XMLReader->getAttribute('cost')
							];

							$breed['characteristics'][$lastCharacteristicId][] = $characteristicRange;

							break;
					}
				}
			}

			foreach ($breed['characteristics'] as $k => $_) {
				usort($breed['characteristics'][$k], [BreedHelper::class, 'sortCharacteristics']);
			}

			$XMLReader->close();

			self::$breeds[$breed['id']] = $breed;
		}
	}
	
	private static function sortCharacteristics(array $a, array $b)
	{
		return (int)$a['range'][0] > (int)$b['range'][0];
	}

	public static function getFromId(int $breedId) : ?array
	{
		if (!count(self::$breeds)) {
			self::loadBreeds();
		}

		if (isset(self::$breeds[$breedId])) {
			return self::$breeds[$breedId];
		}

		return null;
	}

	public static function getFromName(string $breedName) : ?array
	{
		if (!count(self::$breeds)) {
			self::loadBreeds();
		}

		foreach (self::$breeds as $breed) {
			if ($breed['name'] === $breedName) {
				return $breed;
			}
		}

		return null;
	}
}