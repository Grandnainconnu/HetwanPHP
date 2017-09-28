<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-04 09:18:58
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-13 18:35:39
 */

namespace App;

use Monolog\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;


class AppKernel
{
	/**
	 * @var \DI\ContainerBuilder
	 */
	protected $containerBuilder;

	/**
	 * @var \DI\Container
	 */
	protected static $container;

	public function __construct()
	{
		$this->makeContainerBuilder();
		$this->buildDependencies();
		self::$container = $this->containerBuilder->build();
	}

	private function makeContainerBuilder()
	{
		$containerBuilder = new \DI\ContainerBuilder();
		$containerBuilder->useAutowiring(true);
		$containerBuilder->useAnnotations(true);
		
		// $containerBuilder->setDefinitionCache(new \Doctrine\Common\Cache\ApcCache()); CACHE

		$this->containerBuilder = $containerBuilder;
	}

	private function buildDependencies()
	{
		return $this->containerBuilder->addDefinitions([
			'configuration' => \DI\Object('Hetwan\Core\Configuration')->constructor(self::getRootDir().'/app/config/config.yml'),
			'database' => \DI\object('Hetwan\Core\Database')->constructorParameter('entitiesPath',  self::getRootDir().'/src/Entity'),
			'logger' => \DI\factory(function () {
		    	$logger = new Logger('HetwanPHP');

		    	//$fileHandler = new StreamHandler($this->getLogDir().'/'.date('d-m-Y'), Logger::DEBUG);
		    	//$fileHandler->setFormatter(new LineFormatter());
		    	//$logger->pushHandler($fileHandler);

		    	return $logger;
			}),
		]);
	}

	public static function getContainer()
	{
		return self::$container;
	}

	public static function getRootDir()
    {
		return dirname(__DIR__);
    }
    
    public static function getLogDir()
    {
		return dirname(__DIR__).'/var/logs';
    }
}