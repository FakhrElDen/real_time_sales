<?php

use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function() {
    Route::get('analytics', [OrderController::class, 'index']);
    Route::post('create', [OrderController::class, 'create']);
});