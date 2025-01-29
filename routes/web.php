<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Orders;
use App\Http\Controllers\TestController;
use App\Http\Controllers\OrderController;

// main url for updating orders
Route::get('/', [OrderController::class, 'showOrder'])->name('order.show');

// used in updating status in js/kds page
Route::post('/orders/update-status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
//used in updating header status
Route::get('/header', [OrderController::class, 'headerFetch'])->name('headerFetch');




// unknown url yet
Route::match(['post', 'put'], '/update-order-status', [OrderController::class, 'updateOrderStatus'])->name('order.updateOrderStatus');
