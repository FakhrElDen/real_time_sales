<?php

namespace App\Http\Controllers;

use App\Http\Services\WeatherService;

class WeatherController extends Controller
{
    public function __construct(protected WeatherService $weatherService) 
    {
        //
    }

    public function weatherRecommendations()
    {
        $temperature = $this->weatherService->getCurrentTemperature();

        if ($temperature === null) {
            return response()->json(['error' => 'Could not fetch weather data.'], 500);
        }

        $recommendation = $this->weatherService->getRecommendation($temperature);

        return response()->json([
            'city' => 'Cairo',
            'temperature' => $temperature . ' °C',
            'recommendation' => $recommendation,
        ]);
    }
}
