<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function() {
    Route::get('analytics', [OrderController::class, 'analytics']);
    Route::get('recommendations', [OrderController::class, 'recommendations']);
    Route::post('create', [OrderController::class, 'create']);
});

Route::get('weather/recommendations', [WeatherController::class, 'weatherRecommendations']);
