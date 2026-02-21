<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\auth\Login;
use App\Http\Controllers\auth\Logout;
use App\Http\Controllers\auth\Register;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Livewire\Chat;
use Illuminate\Support\Facades\Route;

// ? **login Routes**

Route::view('login', 'auth.login')
    ->middleware(['guest', 'throttle:AuthView'])
    ->name('login');

Route::post('login', Login::class)
    ->middleware(['guest', 'throttle:login']);

// ? **register Routes**

Route::view('/register', 'auth.register')
    ->middleware(['guest', 'throttle:AuthView'])
    ->name('register');

Route::post('register', Register::class)
    ->middleware(['guest', 'throttle:register']);

// ? **logout**

Route::post('/logout', Logout::class)
    ->name('logout')
    ->middleware(['auth', 'throttle:logout']);

// ? **home**

Route::view('/home', 'home')
    ->middleware('throttle:AuthView')
    ->name('home');

// ?  //delete Route\\

Route::delete('delete-account', [UserController::class, 'deleteAccount'])
    ->middleware('auth', 'throttle:delete-account')
    ->name('delete-account');

// ? **settings Routes**

Route::view('/settings', 'settings/index')
    ->middleware(['auth', 'throttle:view'])
    ->name('settings');

// ? **profile Routes**

Route::get('profile/edit', [ProfileController::class, 'edit'])
    ->middleware(['auth', 'throttle:view'])
    ->name('profile.edit');

Route::get('profile/{user}', [ProfileController::class, 'show'])
    ->middleware('auth')
    ->name('profile.show');

Route::put('profile/update', [ProfileController::class, 'update'])
    ->middleware(['auth', 'throttle:profile'])
    ->name('profile.update');

// ? **friend request Routes**

Route::post('profile/friend-request', [ProfileController::class, 'sendFriendRequest'])
    ->middleware(['auth', 'throttle:profile'])
    ->name('friend-request.send');

Route::delete('profile/friend-request/{friendRequest}', [ProfileController::class, 'deleteFriendRequest'])
    ->middleware(['auth', 'throttle:profile'])
    ->name('friend-request.cancel');

// ? **password Routes**

Route::view('edit.password', 'edits/security/edit-password')
    ->middleware(['auth', 'throttle:view'])
    ->name('edit.password');

Route::put('edit.password', [SecurityController::class, 'updatePassword'])
    ->middleware('auth', 'throttle:password')
    ->name('profile.updatepassword');

// ? **pin code Routes**

Route::view('edit.pin-code', 'edits/security/edit-pin-code')
    ->middleware(['auth', 'throttle:view'])
    ->name('edit.pin-code');

Route::put('edit.pin-code', [SecurityController::class, 'updatePinCode'])
    ->middleware('auth', 'throttle:pin-code')
    ->name('profile.updatePinCode');

// ? **email Routes**

Route::get('edit-email', [EmailController::class, 'editemail'])
    ->middleware(['auth', 'throttle:view'])
    ->name('edit-email');

Route::get('confirm-email', [EmailController::class, 'confirmemail'])
    ->middleware(['auth', 'throttle:view'])
    ->name('confirm-email');

Route::post('edit-email', [EmailController::class, 'sendEmailotp'])
    ->middleware(['auth', 'throttle:email'])
    ->name('send-email-otp');

Route::put('edit-email', [EmailController::class, 'updateEmail'])
    ->middleware('auth', 'throttle:confirm-email')
    ->name('update-email');

// ? **phone Routes**

Route::get('edit-phone', [PhoneController::class, 'editphone'])
    ->middleware(['auth', 'throttle:view'])
    ->name('edit-phone');

Route::get('confirm-phone', [PhoneController::class, 'confirmphone'])
    ->middleware(['auth', 'throttle:view'])
    ->name('confirm-phone');

Route::post('edit-phone', [PhoneController::class, 'sendphone'])
    ->middleware('auth', 'throttle:phone')
    ->name('send-phone-otp');

Route::put('confirm-phone', [PhoneController::class, 'updatephone'])
    ->middleware('auth', 'throttle:confirm-phone')
    ->name('update-phone');

// ? **ticket Routes**

Route::resource('tickets', TicketController::class)
    ->middleware(['auth', 'throttle:view'])
    ->except(['destroy', 'update', 'store']);

Route::post('tickets', [TicketController::class, 'store'])
    ->middleware(['auth', 'throttle:tickets'])
    ->name('tickets.store');

Route::put('tickets/{ticket}', [TicketController::class, 'update'])
    ->middleware(['auth', 'throttle:tickets'])
    ->name('tickets.update');

Route::delete('tickets/{ticket}', [TicketController::class, 'destroy'])
    ->middleware(['auth', 'throttle:tickets'])
    ->name('tickets.destroy');

Route::patch('tickets/{ticket}/close', [TicketController::class, 'close'])
    ->middleware(['auth', 'throttle:tickets'])
    ->name('tickets.close');

// ? **dashboard for user**

Route::get('dashboard', [DashboardController::class, 'dashboard'])
    ->middleware(['auth', 'throttle:view'])
    ->name('dashboard');

Route::get('log-dashboard', [DashboardController::class, 'logdashboard'])
    ->middleware(['auth', 'throttle:view'])
    ->name('log-dashboard');

// ? **transaction Route**

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

// ? **deposit Route**

Route::view('payment_method', 'payment/method')
    ->middleware(['auth', 'throttle:view'])
    ->name('payment_method');

Route::post('payment_method', [PaymentController::class, 'PaymentMethod'])
    ->middleware(['auth', 'throttle:view'])
    ->name('payment_method.post');

// ? **payment Route**

Route::view('deposit', 'payment/deposit')
    ->middleware(['auth', 'throttle:view'])
    ->name('deposit');

Route::post('/payment/create', [PaymentController::class, 'createPayment'])
    ->middleware(['auth', 'throttle:payment'])
    ->name('payment.create');

Route::get('/payment/capture', [PaymentController::class, 'capturePayment'])
    ->middleware(['auth', 'throttle:payment'])
    ->name('payment.capture');

// ? **notification Route**

Route::get('notifications', [NotificationController::class, 'index'])
    ->middleware(['auth', 'throttle:view'])
    ->name('notifications');

// ? **product Route**

Route::resource('products', ProductController::class)
    ->middleware(['auth', 'throttle:view'])
    ->except(['destroy', 'update', 'store']);

Route::get('myproducts', [ProductController::class, 'myproducts'])
    ->middleware(['auth', 'throttle:view'])
    ->name('products.mine');

Route::post('products', [ProductController::class, 'store'])
    ->middleware(['auth', 'throttle:products'])
    ->name('products.store');

Route::put('products/{product}/update', [ProductController::class, 'update'])
    ->middleware(['auth', 'throttle:products'])
    ->name('products.update');

Route::delete('products/{product}/delete', [ProductController::class, 'destroy'])
    ->middleware(['auth', 'throttle:products'])
    ->name('products.destroy');

Route::patch('products/{product}/close', [ProductController::class, 'close'])
    ->middleware(['auth', 'throttle:products'])
    ->name('products.close');

Route::patch('products/{product}/open', [ProductController::class, 'open'])
    ->middleware(['auth', 'throttle:products'])
    ->name('products.open');

// ? **purchase Route**


Route::post('purchase/{product}', [PurchaseController::class, 'purchase'])
    ->middleware(['auth', 'throttle:products'])
    ->name('purchase');

// ? **chat Route**

Route::middleware('auth')->group(function () {
    // Route::get('/chat/{user_id}', [MessageController::class, 'getMessages']);
    // Route::post('/chat/send', [MessageController::class, 'sendMessage']);
    Route::get('chat', Chat::class)->name('chat');
});

// ? **admin Route**

Route::middleware(['auth', 'admin', 'throttle:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('', [AdminController::class, 'index'])->name('index');

    Route::get('/users', [AdminController::class, 'index'])->name('users.index');

    Route::get('/users/logs', [AdminController::class, 'index'])->name('users.logs');

    Route::get('/deposits', [AdminController::class, 'index'])->name('deposits.index');

    Route::get('/products', [AdminController::class, 'index'])->name('products.index');

    Route::get('/purchases', [AdminController::class, 'index'])->name('purchases.index');

    Route::get('/transactions', [AdminController::class, 'index'])->name('transactions.index');

    Route::get('/tickets', [AdminController::class, 'index'])->name('tickets.index');
});
