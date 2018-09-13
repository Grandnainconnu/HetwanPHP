<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-27 22:11:25
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 22:14:36
 */

namespace Hetwan\Helper;


final class HashHelper
{
	private const HASH = [
		'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
     	'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
        '-', '_'
	];

	public static function generateKey($size = 64) : string
	{
    	$key = '';
    	$hashKeySize = count(HashHelper::HASH);

    	if ($size > $hashKeySize) {
    		$size = $hashKeySize;
    	}

    	for ($i = 1; $i <= $size; $i++) {
    		$key .= HashHelper::HASH[rand(0, $hashKeySize - 1)];
    	}

    	return $key;
	}

	public static function encryptValue($value, $key) : string
	{
		$key = str_split($key);
		$splittedValue = str_split($value);
		$cryptedValue = '1';

		for ($i = 0; $i < strlen($value); $i++) {
			$pKeys = [ord($splittedValue[$i]), ord($key[$i])];
			$hKeys = [$pKeys[0] / 16, $pKeys[0] % 16];
			$cryptedValue .= HashHelper::HASH[($hKeys[0] + $pKeys[1]) % count(HashHelper::HASH)] . HashHelper::HASH[($hKeys[1] + $pKeys[1]) % count(HashHelper::HASH)];
		}

		return $cryptedValue;
	}

    public static function cellIdEncode(int $cellId) : string
    {
        return self::HASH[$cellId / 64] . self::HASH[$cellId % 64];
    }

    public static function cellIdDecode(string $cellId) : int
    {
        $cellId = str_split($cellId);

        return array_search($cellId[0], self::HASH) * 64 + array_search($cellId[1], self::HASH);
    }
}