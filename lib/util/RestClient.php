<?php

namespace Lib\Util;

use Exception;

class RestClient
{
    public static function request($url, $method = 'GET', $params = [], $authorization = NULL, $convert = TRUE)
    {
        $ch = curl_init();

        if ($method == 'POST' or $method == 'PUT') {
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($params));
            curl_setopt($ch, CURLOPT_POST, TRUE);
        } else if (($method == 'GET' or $method == 'DELETE') and !empty($params)) {
            $url .= '?' . http_build_query($params);
        }

        $defaults = array(
            CURLOPT_URL => $url,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_RETURNTRANSFER => TRUE,
            CURLOPT_SSL_VERIFYPEER => FALSE,
            CURLOPT_CONNECTTIMEOUT => 10
        );

        if (!empty($authorization)) {
            $defaults[CURLOPT_HTTPHEADER] = ['Authorization: ' . $authorization];
        }

        curl_setopt_array($ch, $defaults);
        $output = curl_exec($ch);

        curl_close($ch);

        if ($convert) {
            $return = json_decode($output, TRUE);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception('Return is not JSON. Check the URL: ' . $output);
            }
        } else {
            $return = $output;
        }

        return $return;
    }
}
