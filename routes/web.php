<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Orders;
use App\Http\Controllers\TestController;
use App\Http\Controllers\OrderController;

// Route::get('/', function () {
//     return redirect('/new-orders');
// });


// Route::get('/new-orders', function () {
//     return view('orders.new-orders');
// });

Route::get('/', [OrderController::class, 'showOrder'])->name('order.show');

// Route::post('/update-order-status', [OrderController::class, 'updateStatus']);
// used in updating status in js
Route::post('/orders/update-status', [OrderController::class, 'updateOrderStatus'])->name('orders.updateStatus');
//used in updating header
Route::get('/header', [OrderController::class, 'headerFetch'])->name('headerFetch');



Route::match(['post', 'put'], '/update-order-status', [OrderController::class, 'updateStatus'])->name('order.show');

Route::get('/in-progress-orders', function () {
    return view('orders.in-progress-orders');
});

Route::get('/completed-orders', function () {
    return view('orders.completed-orders');
});
