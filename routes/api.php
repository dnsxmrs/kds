<?php

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Orders;
use App\Http\Controllers\TestController;
use App\Http\Middleware\CheckPosSource;



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/test-order', [TestController::class, 'testOrder']);

// production routes
Route::middleware([CheckPosSource::class])->group(function () {
    Route::prefix('v1')->group(function () {
        // order from POS to KDS
        Route::post('/push-order', [APIController::class, 'order']);
        // order from WEB to KDS
        Route::post('/web-to-kds', [APIController::class, 'webToKds']);

        Route::post('/cancel-order-from-web', [APIController::class, 'cancelOrderFromWeb']);
        Route::post('/order-complete', [APIController::class, 'orderComplete']);

    });
});

// health checks
Route::get('/health', [APIController::class, 'check']);
