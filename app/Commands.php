<?php

namespace App;

use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\Guild\Invite;
use Lib\Annotation\Command;
use Lib\Text;
use Lib\Voice;

class Commands
{
    /**
     * @Command(name="!php")
     * @return void
     */
    public static function textPHP(Discord $discord, Message $message): void
    {
        Text::sendText($discord, $message->channel_id, 'PHP é mestre!');
    }

    /**
     * @Command(name="!cabo")
     * @return void
     */
    public static function textCabo(Discord $discord, Message $message): void
    {
        Text::sendText($discord, $message->channel_id, 'https://imagizer.imageshack.com/img922/756/ijYNtC.png');
    }

    /**
     * @Command(name="!cat")
     * @return void
     */
    public static function voiceCat(Discord $discord, Message $message): void
    {
        foreach ($message->channel->guild->voice_states as $voiceState) {
            if ($voiceState->user_id === $message->author->id) {
                $channel_id = $voiceState->channel_id;
            }
        }

        Voice::sendVoice($discord, $channel_id, 'assets/sounds/cat.mp3');
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
            Text::sendText($discord, $message->channel_id, $invite->invite_url);
        });
    }
}
