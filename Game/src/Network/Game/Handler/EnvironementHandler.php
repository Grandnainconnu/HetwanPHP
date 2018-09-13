<?php

namespace Hetwan\Network\Game\Handler;

use Hetwan\Helper\MapDataHelper;
use Hetwan\Network\Game\Base\Handler\HandlerTrait;


class EnvironementHandler extends \Hetwan\Network\Base\Handler\Handler
{
	use HandlerTrait;

    /**
     * @Inject
     * @var \Hetwan\Helper\MapDataHelper
     */
    private $mapDataHelper;

	public function handle(string $data) : bool
	{
		switch (substr($data, 0, 1)) {
			case 'D':
				$this->changePlayerOrientation((int)substr($data, 1));

				break;
			default:
                $this->logger->debug('Unable to handle environment packet: ' . $data . PHP_EOL);

				break;
		}

		return true;
	}

	private function changePlayerOrientation(int $direction) : void
	{
		$this->getPlayer()->setOrientation($direction);

		$this->mapDataHelper->updatePlayerOrientation($this->getPlayer()->getMapId(), $this->getPlayer());
	}
}