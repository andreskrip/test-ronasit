<?php

namespace App;

use App\Services\ApiRequestService;

class Weather
{
    private const BASE_URL = 'api.openweathermap.org/data/2.5/weather';
    private const APPID = '12ebe7871a02e9fbdd88064aadb5c124';
    private const LANG = 'ru';

    public static function apiRequest(array $data): array
    {
        // form query parameters to Guzzle client
        $params = [];
        $params['query']['appid'] = self::APPID;
        $params['query']['lang'] = self::LANG;
        $params['query']['q'] = $data['q'];
        $params['query']['units'] = $data['units'];

        // execute API request
        $response = ApiRequestService::apiGetRequest(self::BASE_URL, $params);

        // handle 400+ response codes (errors)
        if ($response['cod'] >= 400) {
            switch ($response['cod']) {
                // 400 is returned when the city field was empty
                case 400:
                    $response['message'] = 'Не введен город';
                    break;
                // 404 is returned when the city typed incorrectly or not exist
                case 404:
                    $response['message'] = 'Город не найден';
                    break;
                // other codes of this group are independent of user actions
                default:
                    $response['message'] = 'Внутренняя ошибка сервиса';
                    break;
            }
            return $response;
        }

        // create the result array and fill it with response data
        $weather = [];

        $weather['cod'] = (int)$response['cod'];
        $weather['city'] = (string)$response['name'];
        $weather['icon'] = (string)$response['weather'][0]['icon'];
        $weather['description'] = (string)$response['weather'][0]['description'];
        $weather['temp'] = (int)round($response['main']['temp']);
        $weather['feelsTemp'] = (int)round($response['main']['feels_like']);
        // convert hPa to mmHg
        $weather['pressure'] = (int)($response['main']['pressure'] / 1.33322);
        $weather['humidity'] = (int)$response['main']['humidity'];
        $weather['windSpeed'] = (int)$response['wind']['speed'];
        //determine the direction of the wind by dividing into 8 sectors and rounding to match the array key
        $directions = ['северный', 'северо-восточный', 'восточный', 'юго-восточный',
            'южный', 'юго-западный', 'западный', 'северо-западный', 'северный'];
        $weather['windDirection'] = (string)$directions[round(($response['wind']['deg']) / 45)];

        return $weather;
    }
}
