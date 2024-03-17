<?php

namespace App\Http\Services;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Config;

class WeatherForecastService
{
    protected $client;
    protected $apiKey;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->apiKey = Config::get('services.openWeather.openWeatherKey.key');
        $this->forecastWeatherDataAPI = Config::get('services.openWeather.openWeatherDataUrl.forecast');

    }

    public function getForecast($latitude, $longitude, $date)
    {
        $response = $this->client->get($this->forecastWeatherDataAPI, [
            'query' => [
                'lat' => $latitude,
                'lon' => $longitude,
                'exclude' => 'current,minutely,hourly',
                'appid' => $this->apiKey,
                'dt' => strtotime($date),
            ],
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }
}
