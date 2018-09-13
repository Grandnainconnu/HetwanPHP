<?php

/**
 * @Author: jeanw
 * @Date:   2017-11-01 21:50:13
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-11-01 22:24:15
 */

namespace Hetwan\Helper\Player\Interaction;

use Hetwan\Helper\HashHelper;
use Hetwan\Network\Game\Protocol\Enum\ActionTypeEnum;


class MovementInteractionHelper implements \Hetwan\Helper\Player\Interaction\Base\InteractionInterface
{
	/**
	 * @Inject
	 * @var \Hetwan\Helper\MapDataHelper
	 */
	private $mapDataHelper;

	/**
	 * @var \Hetwan\Entity\Game\PlayerEntity
	 */
	private $player;

	/**
	 * @var string
	 */
	private $path;

	public function __construct(\Hetwan\Entity\Game\PlayerEntity $player, $path)
	{
		$this->player = $player;
		$this->path = $path;
	}

	public function begin() : void
	{
		$this->mapDataHelper->movePlayer($this->player->getMapId(), $this->player, $this->path);
	}

	public function end() : void
	{
		$this->player->setCellId(HashHelper::cellIdDecode(substr($this->path, -2)))
					 ->setOrientation(ord(substr($this->path, -3, 1)) - ord('a'));
	}

	public function cancel(int $orientation, int $cellId) : void
	{
		$this->player->setCellId($cellId)
					 ->setOrientation($orientation);
	}

	public function getType() : int
	{
		return ActionTypeEnum::MOVEMENT;
	}
}