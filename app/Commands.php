<?php

namespace App;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\Guild\Invite;
use Discord\Voice\VoiceClient;
use Lib\Annotation\Command;

class Commands
{
    /**
     * @Command(name="!php")
     * @return void
     */
    public static function textPHP(Discord $discord, Message $message): void
    {
        $channel = $discord->getChannel($message->channel_id);
        $channel->sendMessage('PHP é mestre!');
    }

    /**
     * @Command(name="!cat")
     * @return void
     */
    public static function voiceCat(Discord $discord, Message $message): void
    {
        $channel = NULL;
        foreach ($message->channel->guild->voice_states as $voiceState) {
            if ($voiceState->user_id === $message->author->id) {
                $channel = $discord->getChannel($voiceState->channel_id);
            }
        }

        if (!$channel) {
            return;
        }

        $discord->joinVoiceChannel($channel)->then(function (VoiceClient $voiceChannel) {
            $voiceChannel->playFile('assets/sounds/cat.mp3')->then([$voiceChannel, 'close']);
        });
    }

    /**
     * @Command(name="!invite")
     * @return void
     */
    public static function textInvite(Discord $discord, Message $message): void
    {
        $channel = $discord->getChannel($message->channel_id);
        $channel->createInvite([
            'max_age' => 60,
            'max_uses' => 5,
            'temporary' => TRUE
        ])->done(function (Invite $invite) use ($discord, $message) {
            $channel = $discord->getChannel($message->channel_id);
            $channel->sendMessage($invite->invite_url);
        });
    }
}
