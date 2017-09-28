<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-03 21:35:27
 * @Last Modified by:   jean
 * @Last Modified time: 2017-09-18 14:56:07
 */

namespace Hetwan\Network\Login\Protocol\Formatter;

class LoginMessageFormatter
{
	public static function helloConnectMessage($key)
	{
		return 'HC' . $key;
	}

	public static function wrongClientVersionMessage($requiredVersion)
	{
		return 'AlEv' . $requiredVersion;
	}

	public static function wrongIdentificationPacket()
	{
		return 'AlEE';
	}

	public static function identificationFailedMessage()
	{
		return 'AlEf';
	}

	public static function accountBannedMessage()
	{
		return 'AlEb';
	}

	public static function accountAlreadyConnectedMessage()
	{
		return 'AlEc';
	}

	public static function emptyAccountNickname()
	{
        return 'AlEr';
    }

    public static function notAvailableAccountNickname()
    {
        return 'AlEs';
    }

	public static function queueMessage($position, $subscribers, $nonSubscribers, $isSubscriber, $queuId = -1)
	{
		return 'Af' . $position . '|' . $subscribers . '|' . $nonSubscribers . '|' . $isSubscriber . '|' . $queuId;
	}

	public static function queueOutOfBoundsMessage()
	{
		return 'M116';
	}

	public static function identificationSuccessMessage($hasRights)
	{
		return 'AlK' . $hasRights;
	}

	public static function accountNicknameInformationMessage($nickname)
	{
		return 'Ad' . $nickname;
	}

	public static function accountCommunityInformationMessage($community)
	{
		return 'Ac' . $community;
	}

	public static function accountSecretQuestionInformationMessage($secretQuestion)
	{
		return 'AQ' . str_replace(' ', '+', $secretQuestion);
	}

	public static function serversListMessage($servers)
	{
		$serversInformationsMessage = function($servers)
		{
			$serversList = [];

			foreach ($servers as $server)
				$serversList[] = "{$server->getId()};{$server->getState()};{$server->getPopulation()};{$server->getRequireSubscription()}";

			return $serversList;
		};

		$packet = 'AH' . implode('|', $serversInformationsMessage($servers));

		return $packet;
	}

	public static function playersListMessage($account)
	{
		$packet = 'AxK' . $account->getSubscriptionTimeLeft();
		$serversPlayers = [];

		foreach ($account->getPlayers() as $player)
			if (isset($serversPlayers[$player->getServerId()]))
				$serversPlayers[$player->getServerId()] += 1;
			else
				$serversPlayers[$player->getServerId()] = 1;

		foreach ($serversPlayers as $serverId => $players)
			$packet .= '|' . $serverId . ',' . $players;

		return $packet;
	}

	public static function searchPlayersMessage($players)
	{
		$packet = 'AF';
		$serversPlayers = [];

		foreach ($players as $player)
			if (isset($serversPlayers[$player->getServerId()]))
				$serversPlayers[$player->getServerId()] += 1;
			else
				$serversPlayers[$player->getServerId()] = 1;

		foreach ($serversPlayers as $serverId => $players)
			$packet .= $serverId . ',' . $players . '|';

		return $packet;
	}

	public static function serverInaccessible()
	{
		return 'AXEd';
	}

	public static function serverRequireSubscription()
	{
		return ['M120', 'AXE'];
	}

	public static function serverFull()
	{
		return 'AXEF';
	}

	public static function serverAccess($ipAddress, $port, $ticket)
	{
		return 'AYK' . $ipAddress . ':' . $port . ';' . $ticket;
	}
}