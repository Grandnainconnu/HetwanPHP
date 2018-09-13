<?php

namespace Hetwan\Network\Login\Protocol\Formatter;

use DateTime;


final class LoginMessageFormatter
{
	public static function helloConnectMessage(string $key) : string
	{
		return 'HC' . $key;
	}

	public static function badClientVersionMessage(string $requiredVersion) : string
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

	public static function accountBannedMessage(\DateTime $dateEnd) : string
	{
		if ($dateEnd == null) {
			return 'AlEb';
		} else {
			$today = new DateTime('NOW');
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

	public static function queueMessage(int $position, int $subscribers, int $nonSubscribers, bool $isSubscriber, int $queueId = -1) : string
	{
		return 'Af' . $position . '|' . $subscribers . '|' . $nonSubscribers . '|' . (int)$isSubscriber . '|' . $queueId;
	}

	public static function queueOutOfBoundsMessage() : string
	{
		return 'M116';
	}

	public static function identificationSuccessMessage(bool $hasRights) : string
	{
		return 'AlK' . (int)$hasRights;
	}

	public static function accountNicknameInformationMessage(string $nickname) : string
	{
		return 'Ad' . $nickname;
	}

	public static function accountCommunityInformationMessage(string $community) : string
	{
		return 'Ac' . $community;
	}

	public static function accountSecretQuestionInformationMessage(string $secretQuestion) : string
	{
		return 'AQ' . str_replace(' ', '+', $secretQuestion);
	}

	public static function serversListMessage(array $servers) : string
	{
		$packet = 'AH';
		$serversInformations = [];

		foreach ($servers as $server) {
		    $serversInformations[] = implode(';', [
		        $server->getId(),
                $server->getState(),
                $server->getPopulation(),
                $server->getRequireSubscription()
            ]);
        }

		return $packet . implode('|', $serversInformations);
	}

	public static function playersListMessage(\Hetwan\Entity\AccountEntity $account) : string
	{
		$packet = 'AxK' . $account->getSubscriptionTimeLeft();
		$accountPlayers = $account->getPlayers() ?? [];

		foreach ($accountPlayers as $serverId => $players) {
			$packet .= '|' . $serverId . ',' . count($players);
		}

		return $packet;
	}

	public static function searchPlayersMessage(?array $accountPlayers)  : string
	{
		$packet = 'AF';
		$accountPlayers = $accountPlayers ?? [];

		foreach ($accountPlayers as $serverId => $players) {
			$packet .= $serverId . ',' . $players . '|';
		}

		return $packet;
	}

	public static function serverInaccessible() : string
	{
		return 'AXEd';
	}

	public static function serverRequireSubscription() : array
	{
		return ['M120', 'AXE'];
	}

	public static function serverFull() : string
	{
		return 'AXEF';
	}

	public static function serverAccess(string $ipAddress, int $port, string $ticket) : string
	{
		return 'AYK' . $ipAddress . ':' . $port . ';' . $ticket;
	}
}