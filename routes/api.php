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

// Route::post('/order-post', [APIController::class, 'receiveUpOrder']);
// Route::post('/push-order', [APIController::class, 'order']);
Route::post('/test-order', [TestController::class, 'testOrder']);

// // local routes
// Route::prefix('v1')->group(function () {
//     Route::match(['post', 'put', 'delete'],'/push-order', [APIController::class, 'order']);
//     // Route::match(['post', 'put', 'delete'], '/category-update', [WebhookController::class, 'category']);
// });

// production routes
Route::middleware([CheckPosSource::class])->group(function () {
    Route::prefix('v1')->group(function () {
        Route::post('/push-order', [APIController::class, 'order']);
    });
});

// health checks
Route::get('/health', [APIController::class, 'check']);
