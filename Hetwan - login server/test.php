<?php

/**
 * @Author: jean
 * @Date:   2017-09-21 23:04:11
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-22 13:04:47
 */

require __DIR__.'/vendor/autoload.php';

define('DB_IP', '127.0.0.1');
define('DB_NAME', 'hetwan-game');
define('DB_USER', 'root');
define('DB_PASS', '');
$db = newPdo(DB_IP, DB_USER, DB_PASS, DB_NAME);

/** Fonction **/
function newPdo($ip, $user, $pass, $db) {
    try {
        $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
        $connection = new PDO('mysql:host=' . $ip . ';dbname=' . $db, $user, $pass, $options);
        $connection -> exec('SET NAMES utf8');
        return $connection;
    } catch(Exception $e) {
        die('Error : ' . $e -> getMessage());
    }
}

foreach ($db->query('SELECT * FROM items_templates;')->fetchAll() as $item)
{
	if (isset(Dofus\Statistic::parse($item['effects'])['subAp']))
		var_dump($item);
}