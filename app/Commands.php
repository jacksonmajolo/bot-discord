<?php

namespace App;

use Api\EconomiaAwesome;
use Doctrine\Common\Annotations\AnnotationReader;
use Discord\Discord;
use Discord\Parts\Channel\Message;
use Discord\Parts\Guild\Invite;
use Lib\Annotation\Command;
use Lib\Text;
use Lib\Voice;
use Api\Promobit;
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
    public static function textPiada(Discord $discord, Message $message): void
    {
        Text::sendText($discord, $message->channel_id, 'https://i.imgur.com/xPWOKWW.png');
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
        for ($i = 0; $i < mt_rand(1, 20); $i++) {
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

    /**
     * @Command(name="moedas")
     * @return void
     */
    public static function textMoedas(Discord $discord, Message $message): void
    {
        $moedas = EconomiaAwesome::all();
        if (!$moedas) {
            return;
        }

        $results = [];
        foreach ($moedas as $moeda) {
            $results[str_replace('.', '', $moeda['high'])] = "{$moeda['name']}: R$ " . number_format($moeda['high'], 2, ',', '.');
        }

        krsort($results);
        Text::sendText($discord, $message->channel_id, implode(PHP_EOL, $results));
    }

    /**
     * @Command(name="promo")
     * @return void
     */
    public static function textPromo(Discord $discord, Message $message): void
    {
        $limit = 5;

        $promos = Promobit::list(['page' => 1]);
        if (!isset($promos['offers']) or !$promos['offers']) {
            return;
        }

        $count = 0;
        foreach ($promos['offers'] as $offer) {
            if ($count >= $limit) {
                break;
            }

            Text::sendText($discord, $message->channel_id, Promobit::URL . $offer['offer_url'] . PHP_EOL);
            $count++;
        }
    }
}
