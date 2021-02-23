<?php

namespace App;

use Doctrine\Common\Annotations\AnnotationReader;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\Guild\Invite;
use Lib\Annotation\Command;
use Lib\Text;
use Lib\Voice;
use ReflectionClass;

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
        $channel_id = Voice::channelVoiceFromMessage($message);
        if (!$channel_id) {
            return;
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

    /**
     * @Command(name="!ajuda")
     * @return void
     */
    public static function textAjuda(Discord $discord, Message $message): void
    {
        $reflectionClass = new ReflectionClass(Commands::class);
        $annotationReader = new AnnotationReader();

        $commands = [];
        foreach ($reflectionClass->getMethods() as $reflectionMethod) {
            $methodAnnotation = $annotationReader->getMethodAnnotation($reflectionMethod, Command::class);
            if (!$methodAnnotation) {
                continue;
            }

            $commands[] = $methodAnnotation->getCommand();
        }

        Text::sendText($discord, $message->channel_id, implode(PHP_EOL, $commands));
    }

    /**
     * @Command(name="!listen")
     * @return void
     */
    public static function voiceListen(Discord $discord, Message $message): void
    {
        $channel_id = Voice::channelVoiceFromMessage($message);
        if (!$channel_id) {
            return;
        }

        Voice::sendVoice($discord, $channel_id, 'assets/sounds/hey_listen.mp3');
    }

    /**
     * @Command(name="!alemoes")
     * @return void
     */
    public static function voiceAlemoes(Discord $discord, Message $message): void
    {
        $channel_id = Voice::channelVoiceFromMessage($message);
        if (!$channel_id) {
            return;
        }

        Voice::sendVoice($discord, $channel_id, 'assets/sounds/alemoes.mp3');
    }

    /**
     * @Command(name="!cooler")
     * @return void
     */
    public static function voiceCooler(Discord $discord, Message $message): void
    {
        $channel_id = Voice::channelVoiceFromMessage($message);
        if (!$channel_id) {
            return;
        }

        Voice::sendVoice($discord, $channel_id, 'assets/sounds/cooler.mp3');
    }
}
