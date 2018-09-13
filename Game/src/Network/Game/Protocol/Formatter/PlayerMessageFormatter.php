<?php

namespace Hetwan\Network\Game\Protocol\Formatter;

use Hetwan\Helper\ItemHelper;
use Hetwan\Helper\Player\PlayerHelper;
use Hetwan\Network\Game\Protocol\Enum\ItemPositionEnum;


class PlayerMessageFormatter
{
	public static function playersListMessage(\Hetwan\Entity\Login\AccountEntity $account, iterable $players, int $serverId)
	{
		$packet = 'ALK' . $account->getSubscriptionTimeLeft() . '|' . count($players);

		if (!count($players)) {
			$packet .= '|';
		} else {
			foreach ($players as $player) {
                $packet .= '|' . implode(';', [
                    $player->getId(),
                    $player->getName(),
                    $player->getLevel(),
                    $player->getSkinId(),
                    PlayerHelper::getConvertedColors($player->getColors()),
                    ItemHelper::formatAccessories(ItemHelper::getWithPositions(ItemPositionEnum::ACCESSORY, $player->getItems())),
                    $player->getIsMerchant(),
                    $serverId,
                    $player->getIsDead(),
                    $player->getDeathCount()
                ]);
			}
		}

		return $packet;
	}

	public static function maxPlayersReachedMessage()
	{
		return 'AAEf';
	}

	public static function invalidPlayerNameMessage()
	{
		return 'AAEn';
	}

	public static function playerNameAlreadyTakenMessage()
	{
		return 'AAEa';
	}

	public static function playerCreatedMessage()
	{
		return 'AAK';
	}

	public static function generatedPlayerNameMessage($playerName)
	{
		return 'APK' . $playerName;
	}

	public static function playerDeletetionFailureMessage()
	{
		return 'ADE';
	}
}