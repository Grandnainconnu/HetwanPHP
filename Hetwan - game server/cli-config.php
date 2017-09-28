<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 18:56:21
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-17 23:25:16
 */

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$appKernel = new \App\AppKernel;
$container = \App\AppKernel::getContainer();

//$em = $container->get('database')->getLoginEntityManager();
$em = $container->get('database')->getGameEntityManager();

return ConsoleRunner::createHelperSet($em);