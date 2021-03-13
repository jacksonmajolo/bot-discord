<?php

namespace Lib;

use Discord\DiscordCommandClient;
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
                throw new Exception('Token not found!');
            }

            self::$instance = new Application;
            self::$instance->discord = new DiscordCommandClient([
                'token' => $discordToken,
                'prefix' => '!',
            ]);
        }

        return self::$instance;
    }
}
