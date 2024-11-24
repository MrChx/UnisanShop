<?php

use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', [FrontController::class, 'index'])->name('front.index');

Route::get('search', [FrontController::class, 'search'])->name('front.search');

Route::get('/view-all', [FrontController::class, 'viewAll'])->name('front.viewAll');

Route::get('/browse/{category:slug}', [FrontController::class, 'category'])->name('front.category');

Route::get('/details/{food:slug}', [FrontController::class, 'details'])->name('front.details');

Route::get('check-booking', [OrderController::class, 'checkBooking'])->name('front.check_booking');
Route::post('/check-booking/details', [OrderController::class, 'checkBookingDetails'])->name('front.check_booking_details');

Route::post('/order/begin/{food:slug}', [OrderController::class, 'saveOrder'])->name('front.save_order');

Route::get('/order/booking/costumer-data', [OrderController::class, 'costumerData'])->name('front.costumer_data');
Route::get('/order/booking/{food:slug}', [OrderController::class, 'booking'])->name('front.booking');

Route::post('/order/booking/costumer-data/save', [OrderController::class, 'saveCostumerData'])->name('front.save_costumer_data');

Route::get('/order/payment', [OrderController::class, 'payment'])->name('front.payment');
Route::post('/order/payment/confirm', [OrderController::class, 'paymentConfirm'])->name('front.payment_confirm');

Route::get('/order/finished/{productTransaction:id}', [OrderController::class, 'orderFinished'])->name('front.order_finished');