<?php

namespace Api;

use Lib\Util\RestClient;

class EconomiaAwesome
{
    const URL = 'https://economia.awesomeapi.com.br';

    public static function all(): array
    {
        $results = RestClient::request(self::URL . '/all');
        return $results ? $results : [];
    }
}
