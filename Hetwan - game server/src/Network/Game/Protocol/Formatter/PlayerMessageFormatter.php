<?php

/**
 * @Author: jean
 * @Date:   2017-09-16 12:22:25
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-24 15:30:45
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


class PlayerMessageFormatter
{
	public static function playersListMessage($account, $serverId)
	{
		$playerInformationsMessage = function($player)
		{
			return "|{$player->getId()};{$player->getName()};{$player->getLevel()};{$player->getSkinId()};{$player->getConvertedColors()};{$player->getAccessories()};{$player->getIsMerchant()};{$player->getServerId()};{$player->getIsDead()};{$player->getDeathCount()};";
		};

		$packet = 'ALK' . $account->getSubscriptionTimeLeft() . '|' . count($account->getPlayers());

		if (!count($account->getPlayers()))
			$packet .= '|';
		else
			foreach ($account->getPlayers() as $player)
				if ($player->getServerId() == $serverId)
					$packet .= $playerInformationsMessage($player);

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

	public static function playerDeleteFailedMessage()
	{
		return 'ADE';
	}

	public static function playerStatisticsMessage($player)
	{
		$packet = ['As', $player->getKamas(), $player->getCharacteristicsPoints(), $player->getSpellPoints(), $player->getFaction(), ];
	}
}