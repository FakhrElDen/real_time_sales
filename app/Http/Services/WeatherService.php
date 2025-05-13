<?php

namespace App\Http\Services;

use App\Enums\weatherTemp;
use GuzzleHttp\Client;

class WeatherService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://api.openweathermap.org/data/2.5/';
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('services.weather.key');
    }

    public function getCurrentTemperature($city = 'Cairo')
    {
        $response = $this->client->get($this->baseUrl . 'weather', [
            'query' => [
                'q'     => $city,
                'appid' => $this->apiKey,
                'units' => 'metric',
            ],
            'http_errors' => true,
        ]);

        $data = json_decode($response->getBody()->getContents(), true);

        return $data['main']['temp'] ?? null;
    }

    public function getRecommendation($temperature)
    {
        if ($temperature >= WeatherTemp::HIGH) {
            return 'Promote cold drinks — It\'s hot in Cairo!';
        } elseif ($temperature <= weatherTemp::LOW) {
            return 'Promote hot drinks ☕ — It\'s cold in Cairo!';
        } else {
            return 'Promote seasonal favorites in Cairo.';
        }
    }
}
