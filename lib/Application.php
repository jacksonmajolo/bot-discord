<?php

namespace Lib;

use Discord\DiscordCommandClient;
use Discord\WebSockets\Intents;
use Exception;

class Application
{
    private static $instance;
    public $discord;

    public static function getInstance(): Application
    {
        if (!self::$instance) {
            $discordToken = getenv('DISCORD_TOKEN');
            if (!$discordToken) {
                throw new Exception('Discord Token not found!');
            }

            $commandPrefix = getenv('COMMAND_PREFIX');

            self::$instance = new Application;
            self::$instance->discord = new DiscordCommandClient([
                'token' => $discordToken,
                'prefix' => ($commandPrefix ? $commandPrefix : '!')
            ]);
        }

        return self::$instance;
    }
}
