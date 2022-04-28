<?php

namespace App;

use Doctrine\Common\Annotations\AnnotationReader;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\Channel\Invite;
use Lib\Annotation\Command;
use Lib\Text;
use Lib\Voice;
use ReflectionClass;

class Commands
{
    /**
     * @Command(name="php")
     * @return void
     */
    public static function textPHP(Discord $discord, Message $message): void
    {
        Text::sendText($discord, $message->channel_id, 'PHP é mestre!');
    }

    /**
     * @Command(name="cabo")
     * @return void
     */
    public static function textCabo(Discord $discord, Message $message): void
    {
        Text::sendText($discord, $message->channel_id, 'https://imagizer.imageshack.com/img922/756/ijYNtC.png');
    }

    /**
     * @Command(name="farm")
     * @return void
     */
    public static function textFarm(Discord $discord, Message $message): void
    {
        Text::sendText($discord, $message->channel_id, 'https://cdn.discordapp.com/attachments/591018714758119435/829188392192573490/crime.PNG');
    }


    /**
     * @Command(name="cat")
     * @return void
     */
    public static function voiceCat(Discord $discord, Message $message): void
    {
        Voice::sendVoice($discord, $message, 'assets/sounds/cat.mp3');
    }

    /**
     * @Command(name="invite")
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
     * @Command(name="ajuda")
     * @return void
     */
    public static function textAjuda(Discord $discord, Message $message): void
    {
        $commands = [];

        $reflectionClass = new ReflectionClass(Commands::class);
        foreach ($reflectionClass->getMethods() as $reflectionMethod) {
            $methodAnnotation = (new AnnotationReader())->getMethodAnnotation($reflectionMethod, Command::class);
            if (!$methodAnnotation) {
                continue;
            }

            $commands[] = $methodAnnotation->getCommand();
        }

        Text::sendText($discord, $message->channel_id, implode(PHP_EOL, $commands));
    }

    /**
     * @Command(name="listen")
     * @return void
     */
    public static function voiceListen(Discord $discord, Message $message): void
    {
        Voice::sendVoice($discord, $message, 'assets/sounds/hey_listen.mp3');
    }

    /**
     * @Command(name="alemoes")
     * @return void
     */
    public static function voiceAlemoes(Discord $discord, Message $message): void
    {
        Voice::sendVoice($discord, $message, 'assets/sounds/alemoes.mp3');
    }

    /**
     * @Command(name="vida")
     * @return void
     */
    public static function voiceVida(Discord $discord, Message $message): void
    {
        Voice::sendVoice($discord, $message, 'assets/sounds/vida.mp3');
    }

    /**
     * @Command(name="cooler")
     * @return void
     */
    public static function voiceCooler(Discord $discord, Message $message): void
    {
        Voice::sendVoice($discord, $message, 'assets/sounds/cooler.mp3');
    }

    /**
     * @Command(name="piada")
     * @return void
     */
    public static function textPiada(Discord $discord, Message $message): void
    {
        Text::sendText($discord, $message->channel_id, 'https://instagram.fpoa33-1.fna.fbcdn.net/v/t51.2885-19/s150x150/25013768_561505377526857_7341115491399761920_n.jpg?tp=1&_nc_ht=instagram.fpoa33-1.fna.fbcdn.net&_nc_ohc=HxIvKrfdK8IAX9MVqYX&oh=7de718e1e0c72703528db38c907fa4b8&oe=6063C5CF');
    }

    /**
     * @Command(name="cris")
     * @return void
     */
    public static function textCris(Discord $discord, Message $message): void
    {
        $text = 'Cristiano ';
        for ($i = 0; $i < mt_rand(1, 10); $i++) {
            $text .= ':monkey:';
        }

        Text::sendText($discord, $message->channel_id, $text);
    }

    /**
     * @Command(name="desempregado")
     * @return void
     */
    public static function textDesempregado(Discord $discord, Message $message): void
    {
        Text::sendText($discord, $message->channel_id, 'https://www.linkedin.com/in/cristiano-bonassina/');
    }
}
