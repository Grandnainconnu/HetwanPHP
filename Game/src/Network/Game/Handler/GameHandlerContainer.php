<?php

namespace Hetwan\Network\Game\Handler;

use DateTime;

use Hetwan\Network\Game\Base\Handler\HandlerTrait;
use Hetwan\Network\Game\Protocol\Formatter\{
    FactionMessageFormatter,
    ChannelMessageFormatter,
    GameMessageFormatter,
    ItemMessageFormatter,
    InformationMessageFormatter
};


class GameHandlerContainer extends \Hetwan\Network\Game\Base\Handler\HandlerContainer
{
    /**
     * @Inject
     * @var \Hetwan\Core\EntityManager
     */
    private $entityManager;

    /**
     * @Inject
     * @var \Hetwan\Helper\MapDataHelper
     */
    private $mapDataHelper;

    /**
     * @Inject
     * @var \Hetwan\Loader\SubAreaDataLoader
     */
    private $subAreaLoader;

	use HandlerTrait;

	public function initialize() : void
	{
        // Initialize handlers
	    $this->addHandler('A', ApproachHandler::class)
             ->addHandler('B', BasicHandler::class)
             ->addHandler('c', ChannelHandler::class)
             ->addHandler('e', EnvironementHandler::class)
             ->addHandler('G', GameHandler::class)
             ->addHandler('O', ItemHandler::class);

	    // World entrance
		$this->send(FactionMessageFormatter::subAreasFactionsMessage($this->subAreaLoader->getValues()));
		$this->send(ChannelMessageFormatter::addChannelsMessage(explode(';', $this->getPlayer()->getChannels())));
		$this->send(ChannelMessageFormatter::enabledEmotesMessage());
		$this->send(ItemMessageFormatter::inventoryStatsMessage(
			$this->getPlayer()->getCharacteristics()->getCharacteristic('pods')->getCurrent(),
			$this->getPlayer()->getCharacteristics()->getCharacteristic('pods')->getTotal()
		));
		$this->send(InformationMessageFormatter::welcomeMessage());

		if (($lastConnectionDate = $this->getAccount()->getLastConnectionDate()) !== null && ($lastConnectionIpAddress = $this->getAccount()->getLastConnectionIpAddress()) !== null) {
            $this->send(InformationMessageFormatter::lastConnectionInformationMessage($lastConnectionDate, $lastConnectionIpAddress));
        }

		$this->send(InformationMessageFormatter::currentIpAddressInformationMessage(($ipAddress = $this->client->getConnection()->remoteAddress)));
		$this->send(GameMessageFormatter::queueMessage(1, 0, 0, 1));

		$this->getAccount()
			 ->setLastConnectionDate(new DateTime('NOW'))
			 ->setLastConnectionIpAddress($ipAddress);
	}

	public function onClose() : void
	{
		$this->mapDataHelper->removePlayer($this->getPlayer()->getMapId(), $this->getPlayer());

		$this->entityManager->persist($this->getPlayer());
		$this->entityManager->flush();
	}
}