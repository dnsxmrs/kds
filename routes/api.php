<?php

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Orders;
use App\Http\Controllers\TestController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/orders-post', [APIController::class, 'upOrder']);

Route::post('/try-order', [APIController::class, 'index']);

Route::post('/test-order', [TestController::class, 'testOrder']);

Route::post('/order-post', [APIController::class, 'receiveUpOrder']);
