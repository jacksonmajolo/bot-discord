<?php

namespace Lib;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Voice\VoiceClient;

class Voice
{
    public static function channelVoiceFromMessage(Message $message): ?int
    {
        $channel_id = NULL;
        foreach ($message->channel->guild->voice_states as $voiceState) {
            if ($voiceState->user_id === $message->author->id) {
                $channel_id = $voiceState->channel_id;
            }
        }

        return $channel_id;
    }

    public static function sendVoice(Discord $discord, Message $message, string $pathFile): void
    {
        $channel_id = Voice::channelVoiceFromMessage($message);

        $channel = $channel_id ? $discord->getChannel($channel_id) : NULL;
        if (empty($channel)) {
            return;
        }

        $discord->joinVoiceChannel($channel)->then(function (VoiceClient $voiceChannel) use ($pathFile) {
            $voiceChannel->playFile($pathFile)->then([$voiceChannel, 'close']);
        });
    }
}
