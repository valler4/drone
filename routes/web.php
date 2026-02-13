<?php

use App\Http\Controllers\auth\login;
use App\Http\Controllers\auth\logout;
use App\Http\Controllers\auth\register;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\phoneController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\userController;
use App\Http\Controllers\AdminController;
use App\Models\ticket;
use Illuminate\Support\Facades\Route;

// ? **login routes**

Route::view('login', 'auth.login')
    ->middleware(['guest', 'throttle:AuthView'])
    ->name('login');

Route::post('login', login::class)
    ->middleware(['guest', 'throttle:login']);

// ? **register routes**

Route::view('/register', 'auth.register')
    ->middleware(['guest', 'throttle:AuthView'])
    ->name('register');

Route::post('register', register::class)
    ->middleware(['guest', 'throttle:register']);

// ? **logout**

Route::post('/logout', logout::class)
    ->name('logout')
    ->middleware(['auth', 'throttle:logout']);

// ? **home**

Route::view('/home', 'home')
    ->middleware('throttle:AuthView')
    ->name('home');

// ?  //delete route\\

Route::delete('delete-account', [userController::class, 'deleteAccount'])
    ->middleware('auth', 'throttle:delete-account')
    ->name('delete-account');

// ? **profile routes**

Route::view('/profile', 'profile')
    ->middleware(['auth', 'throttle:view'])
    ->name('profile');

route::get('edit-profile', [ProfileController::class, 'edit'])
    ->middleware(['auth', 'throttle:view'])
    ->name('edit.profile');

Route::put('edit-profile', [ProfileController::class, 'update'])
    ->middleware(['auth', 'throttle:profile'])
    ->name('profile.update');

// ? **password routes**

route::view('edit.password', 'edits/security/edit-password')
    ->middleware(['auth', 'throttle:view'])
    ->name('edit.password');

Route::put('edit.password', [SecurityController::class, 'updatePassword'])
    ->middleware('auth', 'throttle:password')
    ->name('profile.updatepassword');

// ? **pin code routes**

route::view('edit.pin-code', 'edits/security/edit-pin-code')
    ->middleware(['auth', 'throttle:view'])
    ->name('edit.pin-code');

Route::put('edit.pin-code', [SecurityController::class, 'updatePinCode'])
    ->middleware('auth', 'throttle:pin-code')
    ->name('profile.updatePinCode');

// ? **email routes**

route::get('edit-email', [EmailController::class, 'editemail'])
    ->middleware(['auth', 'throttle:view'])
    ->name('edit-email');

route::get('confirm-email', [EmailController::class, 'confirmemail'])
    ->middleware(['auth', 'throttle:view'])
    ->name('confirm-email');

Route::post('edit-email', [EmailController::class, 'sendEmailotp'])
    ->middleware(['auth', 'throttle:email'])
    ->name('send-email-otp');

Route::put('edit-email', [EmailController::class, 'updateEmail'])
    ->middleware('auth', 'throttle:confirm-email')
    ->name('update-email');

// ? **phone routes**

route::get('edit-phone', [phoneController::class, 'editphone'])
    ->middleware(['auth', 'throttle:view'])
    ->name('edit-phone');

route::get('confirm-phone', [phoneController::class, 'confirmphone'])
    ->middleware(['auth', 'throttle:view'])
    ->name('confirm-phone');

Route::post('edit-phone', [phoneController::class, 'sendphone'])
    ->middleware('auth', 'throttle:phone')
    ->name('send-phone-otp');

Route::put('confirm-phone', [phoneController::class, 'updatephone'])
    ->middleware('auth', 'throttle:confirm-phone')
    ->name('update-phone');

// ? **ticket routes**

route::resource('tickets', TicketController::class)
    ->middleware(['auth', 'throttle:view'])
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

Route::get('dashboard', [dashboardController::class, 'dashboard'])
    ->middleware(['auth', 'throttle:view'])
    ->name('dashboard');

Route::get('log-dashboard', [DashboardController::class, 'logdashboard'])
    ->middleware(['auth', 'throttle:view'])
    ->name('log-dashboard');

// ? **transaction route**

Route::get('transactions', [TransactionController::class, 'index'])
    ->middleware(['auth', 'throttle:view'])
    ->name('transactions');

Route::get('transaction/{transaction}', [TransactionController::class, 'show'])
    ->middleware(['auth', 'throttle:view'])
    ->name('transaction.show');

Route::get('transactions/create', [TransactionController::class, 'create'])
    ->middleware(['auth', 'throttle:view'])
    ->name('transaction.create');

Route::post('transaction/store', [TransactionController::class, 'store'])
    ->middleware(['auth', 'throttle:transfer'])
    ->name('transaction.store');

// ? **deposit route**

Route::view('payment_method', 'payment/method')
    ->middleware(['auth', 'throttle:view'])
    ->name('payment_method');

Route::post('payment_method', [PaymentController::class, 'PaymentMethod'])
    ->middleware(['auth', 'throttle:view'])
    ->name('payment_method.post');

// ? **payment route**

Route::view('deposit', 'payment/deposit')
    ->middleware(['auth', 'throttle:view'])
    ->name('deposit');

Route::post('/payment/create', [PaymentController::class, 'createPayment'])
    ->middleware(['auth', 'throttle:payment'])
    ->name('payment.create');

Route::get('/payment/capture', [PaymentController::class, 'capturePayment'])
    ->middleware(['auth', 'throttle:payment'])
    ->name('payment.capture');


// ? **notification route**

Route::get('notifications', [NotificationController::class, 'index'])
    ->middleware(['auth', 'throttle:view'])
    ->name('notifications');

// ? **product route**

route::resource('products', ProductController::class)
    ->middleware(['auth', 'throttle:view'])
    ->except(['destroy', 'update', 'store']);

route::get('myproducts', [ProductController::class, 'myproducts'])
    ->middleware(['auth', 'throttle:view'])
    ->name('products.mine');

route::post('products', [ProductController::class, 'store'])
    ->middleware(['auth', 'throttle:products'])
    ->name('products.store');

route::put('products/{product}/update', [ProductController::class, 'update'])
    ->middleware(['auth', 'throttle:products'])
    ->name('products.update');

route::delete('products/{product}/delete', [ProductController::class, 'destroy'])
    ->middleware(['auth', 'throttle:products'])
    ->name('products.destroy');

route::patch('products/{product}/close', [ProductController::class, 'close'])
    ->middleware(['auth', 'throttle:products'])
    ->name('products.close');

route::patch('products/{product}/open', [ProductController::class, 'open'])
    ->middleware(['auth', 'throttle:products'])
    ->name('products.open');

// ? **purchase route**

Route::post('purchase/{product}', [PurchaseController::class, 'purchase'])
    ->middleware(['auth', 'throttle:products'])
    ->name('purchase');

// ? **admin route**

Route::get('admin', [AdminController::class, 'index'])
    ->middleware(['auth','admin', 'throttle:view'])
    ->name('admin.index');
