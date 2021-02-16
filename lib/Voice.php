<?php

namespace Lib;

use Discord\Discord;
use Discord\Voice\VoiceClient;
use React\Promise\Deferred;

class Voice
{
    public static function sendVoice(Discord $discord, int $channel_id, string $pathFile): void
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
