<?php

/**
 * @Author: jeanw
 * @Date:   2017-09-03 21:35:27
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-10-25 12:20:37
 */

namespace Hetwan\Network\Login\Protocol\Formatter;


final class LoginMessageFormatter
{
	public static function helloConnectMessage($key) : string
	{
		return 'HC' . $key;
	}

	public static function badClientVersionMessage($requiredVersion) : string
	{
		return 'AlEv' . $requiredVersion;
	}

	public static function badPacketMessage() : string
	{
		return 'AlEE';
	}

	public static function identificationFailedMessage() : string
	{
		return 'AlEf';
	}

	public static function accountBannedMessage($dateEnd) : string
	{
		if ($dateEnd == null) {
			return 'AlEb';
		} else {
			$today = new \DateTime('NOW');
			$difference = $dateEnd->diff($today);

			return 'AlEk' . $difference->format('%d') . '|' . $difference->format('%h') . '|' . $difference->format('%i');
		}
	}

	public static function accountAlreadyConnectedMessage() : string
	{
		return 'AlEa';
	}

	public static function accountAlreadyConnectedOnGameServerMessage() : string
	{
		return 'AlEd';
	}

	public static function emptyAccountNickname() : string
	{
        return 'AlEr';
    }

    public static function notAvailableAccountNickname() : string
    {
        return 'AlEs';
    }

	public static function queueMessage($position, $subscribers, $nonSubscribers, $isSubscriber, $queuId = -1) : string
	{
		return 'Af' . $position . '|' . $subscribers . '|' . $nonSubscribers . '|' . $isSubscriber . '|' . $queuId;
	}

	public static function queueOutOfBoundsMessage() : string
	{
		return 'M116';
	}

	public static function identificationSuccessMessage($hasRights) : string
	{
		return 'AlK' . $hasRights;
	}

	public static function accountNicknameInformationMessage($nickname) : string
	{
		return 'Ad' . $nickname;
	}

	public static function accountCommunityInformationMessage($community) : string
	{
		return 'Ac' . $community;
	}

	public static function accountSecretQuestionInformationMessage($secretQuestion) : string
	{
		return 'AQ' . str_replace(' ', '+', $secretQuestion);
	}

	public static function serversListMessage($servers) : string
	{
		$serversInformationsMessage = function($servers)
		{
			$serversList = [];

			foreach ($servers as $server) {
				$serversList[] = "{$server->getId()};{$server->getState()};{$server->getPopulation()};{$server->getRequireSubscription()}";
			}

			return $serversList;
		};

		$packet = 'AH' . implode('|', $serversInformationsMessage($servers));

		return $packet;
	}

	public static function playersListMessage($account) : string
	{
		$packet = 'AxK' . $account->getSubscriptionTimeLeft();
		$serversPlayers = [];

		foreach ($account->getPlayers() as $player) {
			if (isset($serversPlayers[$player->getServerId()])) {
				$serversPlayers[$player->getServerId()] += 1;
			} else {
				$serversPlayers[$player->getServerId()] = 1;
			}
		}

		foreach ($serversPlayers as $serverId => $players) {
			$packet .= '|' . $serverId . ',' . $players;
		}

		return $packet;
	}

	public static function searchPlayersMessage($players)  : string
	{
		$packet = 'AF';
		$serversPlayers = [];

		foreach ($players as $player) {
			if (isset($serversPlayers[$player->getServerId()])) {
				$serversPlayers[$player->getServerId()] += 1;
			} else {
				$serversPlayers[$player->getServerId()] = 1;
			}
		}

		foreach ($serversPlayers as $serverId => $players) {
			$packet .= $serverId . ',' . $players . '|';
		}

		return $packet;
	}

	public static function serverInaccessible() : string
	{
		return 'AXEd';
	}

	public static function serverRequireSubscription() : string
	{
		return ['M120', 'AXE'];
	}

	public static function serverFull() : string
	{
		return 'AXEF';
	}

	public static function serverAccess($ipAddress, $port, $ticket) : string
	{
		return 'AYK' . $ipAddress . ':' . $port . ';' . $ticket;
	}
}