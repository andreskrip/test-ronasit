<?php

namespace App\Services;

use GuzzleHttp;
use GuzzleHttp\Exception\RequestException;

class ApiRequestService
{
    // GET-request to API method
    public static function apiGetRequest(string $url, array $params): array
    {
        $client = new GuzzleHttp\Client();
        try {
            $response = $client->get($url, $params);
        } catch (RequestException $e) {
            return json_decode($e->getResponse()->getBody()->getContents(), true);
        }
        return json_decode($response->getBody()->getContents(), true);
    }
}
