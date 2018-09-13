<?php

/**
 * @Author: jeanw
 * @Date:   2017-10-25 15:32:49
 * @Last Modified by:   jeanw
 * @Last Modified time: 2017-12-17 01:20:03
 */

namespace Hetwan\Network\Game\Protocol\Formatter;


class ChannelMessageFormatter
{
    public static function addChannelsMessage(array $channels)
    {
    	$packet = ['cC+'];

    	if (!empty($channels)) {
    		foreach ($channels as $channel) {
                $packet[] = $channel;
            }
        }

    	return implode('', $packet);
    }

    public static function removeChannelsMessage(array $channels)
    {
        $packet = ['cC-'];

        if (!empty($channels)) {
            foreach ($channels as $channel) {
                $packet[] = $channel;
            }
        }

        return implode('', $packet);
    }

    public static function enabledEmotesMessage($emotes = '', $suffix = 0)
    {
        return 'eL' . $emotes . '|' . $suffix;
    }

    public static function clientPrivateMessage($copy, $senderId, $senderName, $message)
    {
        return 'cMK' . ($copy ? 'F' : 'T') . '|' . $senderId . '|' . $senderName . '|' . $message;
    }

    public static function clientChannelMessage($channel, $senderId, $senderName, $message)
    {
        return 'cMK' . $channel . '|' . $senderId . '|' . $senderName . '|' . $message;
    }
}