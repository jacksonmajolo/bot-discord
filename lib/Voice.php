<?php

namespace Lib;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Voice\VoiceClient;

class Voice
{
    private static function userChannelVoiceByMessage(Message $message): ?int
    {
        $channels = $message->member->guild->channels;
        if (!$channels) {
            return NULL;
        }

        foreach ($channels as $channel) {
            $members = $channel->members;
            if (!$members) {
                continue;
            }

            foreach ($members as $member) {
                if ($message->author->id != $member->user_id) {
                    continue;
                }

                return $channel->id;
            }
        }


        return NULL;
    }

    public static function sendVoiceByMessage(Discord $discord, Message $message, string $pathFile): void
    {
        $channel_id = Voice::userChannelVoiceByMessage($message);
        if (!$channel_id) {
            return;
        }

        self::sendVoiceFromChannelId($discord, $channel_id, $pathFile);
    }

    public static function sendVoiceFromChannelId(Discord $discord, int $channel_id, string $pathFile): void
    {
        $channel = $discord->getChannel($channel_id);
        if (empty($channel)) {
            return;
        }

        $discord->joinVoiceChannel($channel)->then(function (VoiceClient $voiceChannel) use ($pathFile) {
            $voiceChannel->playFile($pathFile)->then([$voiceChannel, 'close']);
        });
    }
}
