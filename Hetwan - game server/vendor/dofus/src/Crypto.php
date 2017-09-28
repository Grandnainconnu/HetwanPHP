<?php

/**
 * @Author: jean
 * @Date:   2017-09-14 14:34:22
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-15 12:43:28
 */

namespace Dofus;

final class Crypto
{
	const HASH = [
		'a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z',
     	'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z',
        '0', '1', '2', '3', '4', '5', '6', '7', '8', '9',
        '-', '_'
	];

	public static function generateKey($size = 64) 
	{
    	$key = '';
    	$hashKeySize = count(Crypto::HASH);

    	if ($size > $hashKeySize)
    		$size = $hashKeySize;

    	for ($i = 1; $i <= $size; $i++)
    		$key .= Crypto::HASH[rand(0, $hashKeySize - 1)];

    	return $key;
	}

	public static function encryptValue($value, $key)
	{
		$key = str_split($key);
		$splittedValue = str_split($value);
		$cryptedValue = '1';

		for ($i = 0; $i < strlen($value); $i++)
		{
			$pKeys = [ord($splittedValue[$i]), ord($key[$i])];
			$hKeys = [$pKeys[0] / 16, $pKeys[0] % 16];
			$cryptedValue .= Crypto::HASH[($hKeys[0] + $pKeys[1]) % count(Crypto::HASH)] . Crypto::HASH[($hKeys[1] + $pKeys[1]) % count(Crypto::HASH)];
		}

		return $cryptedValue;
	}

}