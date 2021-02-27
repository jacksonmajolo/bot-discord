<?php

namespace Api;

use Lib\Util\RestClient;

class Promobit
{
    const URL = 'https://www.promobit.com.br';

    public static function list(array $params = []): array
    {
        $results = RestClient::request(self::URL . '/Offer/getTimeline/page/' . ($params['page'] ?? 1), 'GET', [], NULL, FALSE);
        return $results ? json_decode(base64_decode($results), TRUE) : [];
    }
}
