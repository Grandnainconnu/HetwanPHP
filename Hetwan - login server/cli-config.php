<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 18:56:21
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-14 11:16:34
 */

use App\AppKernel;

use Doctrine\ORM\Tools\Console\ConsoleRunner;

$appKernel = new AppKernel;
$container = $appKernel::getContainer();

return ConsoleRunner::createHelperSet($container->get('database')->getEntityManager());