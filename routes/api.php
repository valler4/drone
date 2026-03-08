<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\TicketController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\SearchController;
use App\Http\Controllers\Api\SecurityController;
use App\Http\Controllers\Api\TransactionController;

Route::name('api.')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/GoogleCallback', [AuthController::class, 'HandelGoogleCallback']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::post('/password/update', [SecurityController::class, 'updatePassword']);

        Route::post('/pin-code/update', [SecurityController::class, 'updatePinCode']);

        Route::apiResource('tickets', TicketController::class);
        Route::patch('/tickets/{ticket}', [TicketController::class, 'close']);

        Route::get('/profile', [ProfileController::class, 'edit']);
        Route::get('/profile/{user}', [ProfileController::class, 'show']);
        Route::post('/profile/friend-request/send/{user}', [ProfileController::class, 'sendFriendRequest']);
        Route::delete('/profile/friend-request/cancel/{user}', [ProfileController::class, 'deleteFriendRequest']);
        Route::post('/profile', [ProfileController::class, 'update']);

        Route::apiResource('transactions', TransactionController::class)->except(['destroy', 'update']);

        Route::get('/search', [SearchController::class, 'index']);

        Route::post('/purchase/{product}', [PurchaseController::class, 'purchase']);

        Route::apiResource('products', ProductController::class);
        Route::get('/products/mine', [ProductController::class, 'mine']);
        Route::patch('/products/{product}/close', [ProductController::class, 'close']);
        Route::patch('/products/{product}/open', [ProductController::class, 'open']);

        Route::post('/payment/create', [PaymentController::class, 'createPayment']);
        Route::get('/payment/capture', [PaymentController::class, 'capturePayment']);

        Route::get('/dashboard', [DashboardController::class, 'dashboard']);
        Route::get('/dashboard/logs', [DashboardController::class, 'logDashboard']);



        });
});
