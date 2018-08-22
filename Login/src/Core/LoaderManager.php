<?php

namespace Hetwan\Core;


final class LoaderManager
{
    /**
	 * @Inject
	 * @var \DI\Container
	 */
    private $container;

	/**
	 * @var array
	 */
	private $loaders = [];

	public function initialize($loader) : void
	{
		if (!isset($this->loaders[$loader])) {
			$this->loaders[$loader] = $this->container->make($loader);
			$this->loaders[$loader]->initialize();
		}
	}

	public function get($loader) : object
	{
		if (!isset($this->loaders[$loader])) {
			throw new LoaderManagerException("Loader {$loader} isn't initialized.");
		}

		return $this->loaders[$loader];
	}
}

class LoaderManagerException extends \Exception {}