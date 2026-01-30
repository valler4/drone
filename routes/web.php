<?php

use App\Http\Controllers\auth\login;
use App\Http\Controllers\auth\logout;
use App\Http\Controllers\auth\register;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\phoneController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\userController;
use App\Models\ticket;
use Illuminate\Support\Facades\Route;

// ? **login routes**

Route::view('login', 'auth.login')
    ->middleware('guest')
    ->name('login');

Route::post('login', login::class)
    ->middleware(['guest', 'throttle:login']);

// ? **register routes**

Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');

Route::post('register', register::class)
    ->middleware(['guest', 'throttle:register']);

// ? **logout**

Route::post('/logout', logout::class)
    ->name('logout')
    ->middleware('auth');

// ? **home**

Route::view('/home', 'home')
    ->name('home');

// ?  //delete route\\

Route::delete('delete-account', [userController::class, 'deleteAccount'])
    ->middleware('auth', 'throttle:delete-account')
    ->name('delete-account');

// ? **profile routes**

Route::view('/profile', 'profile')
    ->middleware('auth')
    ->name('profile');

route::get('edit-profile', [ProfileController::class, 'edit'])
    ->middleware('auth')
    ->name('edit.profile');

Route::put('edit-profile', [ProfileController::class, 'update'])
    ->middleware(['auth', 'throttle:profile'])
    ->name('profile.update');

// ? **password routes**

route::view('edit.password', 'edits/security/edit-password')
    ->middleware('auth')
    ->name('edit.password');

Route::put('edit.password', [SecurityController::class, 'updatePassword'])
    ->middleware('auth', 'throttle:password')
    ->name('profile.updatepassword');

// ? **pin code routes**

route::view('edit.pin-code', 'edits/security/edit-pin-code')
    ->middleware('auth')
    ->name('edit.pin-code');

Route::put('edit.pin-code', [SecurityController::class, 'updatePinCode'])
    ->middleware('auth', 'throttle:pin-code')
    ->name('profile.updatePinCode');

// ? **email routes**

route::get('edit-email', [EmailController::class, 'editemail'])
    ->middleware('auth')
    ->name('edit-email');

route::get('confirm-email', [EmailController::class, 'confirmemail'])
    ->middleware('auth')
    ->name('confirm-email');

Route::post('edit-email', [EmailController::class, 'sendEmailotp'])
    ->middleware(['auth', 'throttle:email'])
    ->name('send-email-otp');

Route::put('edit-email', [EmailController::class, 'updateEmail'])
    ->middleware('auth', 'throttle:confirm-email')
    ->name('update-email');

// ? **phone routes**

route::get('edit-phone', [phoneController::class, 'editphone'])
    ->middleware('auth')
    ->name('edit-phone');

route::get('confirm-phone', [phoneController::class, 'confirmphone'])
    ->middleware('auth')
    ->name('confirm-phone');

Route::post('edit-phone', [phoneController::class, 'sendphone'])
    ->middleware('auth', 'throttle:phone')
    ->name('send-phone-otp');

Route::put('confirm-phone', [phoneController::class, 'updatephone'])
    ->middleware('auth', 'throttle:confirm-phone')
    ->name('update-phone');

// ? **ticket routes**

route::resource('tickets', TicketController::class)
    ->middleware('auth')
    ->except(['destroy', 'update', 'store']);

route::post('tickets', [TicketController::class, 'store'])
    ->middleware(['auth', 'throttle:tickets'])
    ->name('tickets.store');

route::put('tickets/{ticket}', [TicketController::class, 'update'])
    ->middleware(['auth', 'throttle:tickets'])
    ->name('tickets.update');

route::delete('tickets/{ticket}', [TicketController::class, 'destroy'])
    ->middleware(['auth', 'throttle:tickets'])
    ->name('tickets.destroy');

route::patch('tickets/{ticket}/close', [TicketController::class, 'close'])
    ->middleware(['auth', 'throttle:tickets'])
    ->name('tickets.close');

// ? **dashboard for user**

Route::view('dashboard', 'dashboard/main-dashboard', [dashboardController::class, 'dashboard'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('log-dashboard', [DashboardController::class, 'logdashboard'])
    ->middleware('auth')
    ->name('log-dashboard');

// ? **transaction route**

Route::get('transactions', [TransactionController::class, 'index'])
    ->middleware('auth')
    ->name('transactions');

Route::get('transaction/{transaction}', [TransactionController::class, 'show'])
    ->middleware('auth')
    ->name('transaction.show');

Route::get('transactions/create', [TransactionController::class, 'create'])
    ->middleware('auth')
    ->name('transaction.create');

Route::post('transaction/store', [TransactionController::class, 'store'])
    ->middleware('auth')
    ->name('transaction.store');

Route::view('amount', 'deposit/amount')
->middleware('auth')
->name('amount');

Route::post('amount', [DepositController::class, 'depositnumber'])
->middleware('auth')
->name('amount.post');

Route::view('deposit', 'deposit/deposit')
->middleware('auth')
->name('deposit');

Route::post('paypal/create', [DepositController::class, 'createPayment'])
    ->middleware('auth');

Route::post('paypal/capture', [DepositController::class, 'capturePayment'])
    ->middleware('auth');
