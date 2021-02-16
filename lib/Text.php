<?php

namespace Lib;

use Discord\Discord;

class Text
{
    public static function sendText(Discord $discord, int $channel_id, string $message): void
    {
        $channel = $discord->getChannel($channel_id);
        $channel->sendMessage($message);
    }
}
