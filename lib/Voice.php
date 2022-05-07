<?php

namespace Lib;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Voice\VoiceClient;

class Voice
{
    private static function userChannelVoiceByMessage(Discord $discord, Message $message): ?int
    {
        $guilds = $discord->guilds;
        if (!$guilds) {
            return NULL;
        }

        foreach ($guilds as $guild) {
            if ($message->channel->guild_id != $guild->id) {
                continue;
            }

            $channels = $guild->channels;
            if (!$channels) {
                continue;
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
        }

        return NULL;
    }

    public static function sendVoiceByMessage(Discord $discord, Message $message, string $pathFile): void
    {
        $channel_id = Voice::userChannelVoiceByMessage($discord, $message);
        if (!$channel_id) {
            return;
        }

        $channel = $discord->getChannel($channel_id);
        if (empty($channel)) {
            return;
        }

        $discord->joinVoiceChannel($channel)->then(function (VoiceClient $voiceChannel) use ($pathFile) {
            $voiceChannel->playFile($pathFile)->then([$voiceChannel, 'close']);
        });
    }
}
