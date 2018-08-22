<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 18:56:21
 * @Last Modified by:   Jean Walrave
 * @Last Modified time: 2018-04-11 12:32:35
 */

require_once 'vendor/autoload.php';

use App\AppKernel;

use Hetwan\Core\Database;

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$appKernel = new AppKernel;
$container = $appKernel::getContainer();

return ConsoleRunner::createHelperSet($container->get(Database::class)->getEntityManager());