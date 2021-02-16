<?php

namespace Lib;

use Discord\Discord;
use Exception;

class Application
{
    private static $instance;
    public $discord;

    public static function getInstance(): Application
    {
        if (!self::$instance) {
            $ini = parse_ini_file('.env');
            if (!isset($ini['DISCORD_TOKEN']) or !$ini['DISCORD_TOKEN']) {
                throw new Exception('Token not found!');
            }

            self::$instance = new Application;
            self::$instance->discord = new Discord([
                'token' => $ini['DISCORD_TOKEN']
            ]);
        }

        return self::$instance;
    }
}
