<?php

namespace Lib;

use Discord\Discord;
use Exception;
use Monolog\Logger;

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
            self::$instance->discord = new Discord([
                'token' => $discordToken,
                'loggerLevel' => Logger::EMERGENCY,
                'loadAllMembers' => TRUE,
            ]);
        }

        return self::$instance;
    }
}
