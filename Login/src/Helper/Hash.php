<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-27 22:11:25
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-27 22:14:36
 */

namespace Hetwan\Helper;


final class Hash
{
	const HASH = [
		'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
     	'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
        '-', '_'
	];

	public static function generateKey($size = 64) : string
	{
    	$key = '';
    	$hashKeySize = count(Hash::HASH);

    	if ($size > $hashKeySize) {
    		$size = $hashKeySize;
    	}

    	for ($i = 1; $i <= $size; $i++) {
    		$key .= Hash::HASH[rand(0, $hashKeySize - 1)];
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
			$cryptedValue .= Hash::HASH[($hKeys[0] + $pKeys[1]) % count(Hash::HASH)] . Hash::HASH[($hKeys[1] + $pKeys[1]) % count(Hash::HASH)];
		}

		return $cryptedValue;
	}
}