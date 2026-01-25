<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\login;
use App\Http\Controllers\auth\logout;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\userController;
use App\Http\Controllers\auth\register;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\phoneController;
use App\Http\Controllers\SecurityController;
use App\Http\Controllers\TicketController;
use App\Models\ticket;

Route::get('/', function () {
    return view('welcome');
});


//? **login routes**


Route::view('login', 'auth.login')
    ->middleware('guest')
    ->name('login');


Route::post('login', login::class)
    ->middleware(['guest', 'throttle:login']);


//? **register routes**


Route::view('/register', 'auth.register')
    ->middleware('guest')
    ->name('register');


Route::post('register', register::class)
    ->middleware(['guest', 'throttle:register']);

//? **logout**

Route::post('/logout', logout::class)
    ->name('logout')
    ->middleware('auth');

//? **home**

Route::view('/home', 'home')
    ->name('home');


//? **profile routes**


Route::view('/profile', 'profile')
    ->middleware('auth')
    ->name('profile');


route::view('edit-profile', 'edits/edit-profile', [ProfileController::class, 'edit'])
    ->middleware('auth')
    ->name('edit.profile');


Route::put('edit-profile', [ProfileController::class, 'update'])
    ->middleware(['auth', 'throttle:profile'])
    ->name('profile.update');


//? **password routes**


route::view('edit.password', 'edits/security/edit-password')
    ->middleware('auth')
    ->name('edit.password');

Route::put('edit.password', [SecurityController::class, 'updatePassword'])
    ->middleware('auth', 'throttle:password')
    ->name('profile.updatepassword');



route::view('edit.pin-code', 'edits/security/edit-pin-code')
    ->middleware('auth')
    ->name('edit.pin-code');

Route::put('edit.pin-code', [SecurityController::class, 'updatePinCode'])
    ->middleware('auth', 'throttle:pin-code')
    ->name('profile.updatePinCode');


//? **email routes**


route::view('edit-email', 'edits/edit-email/edit-email')
    ->middleware('auth')
    ->name('edit-email');


route::view('confirm-email', 'edits/edit-email/confirm-email')
    ->middleware('auth')
    ->name('confirm-email');


Route::post('edit-email', [EmailController::class, 'sendEmailotp'])
    ->middleware(['auth', 'throttle:email'])
    ->name('send-email-otp');


Route::put('edit-email', [EmailController::class, 'updateEmail'])
    ->middleware('auth', 'throttle:confirm-email')
    ->name('update-email');


Route::post('re-send-edit-email', [EmailController::class, 'resendmail'])
    ->middleware(['auth', 'throttle:resend-email-otp'])
    ->name('resend-email-otp');


//? **phone routes**


route::view('edit-phone', 'edits/edit-phone/edit-phone')
    ->middleware('auth')
    ->name('edit-phone');


route::view('confirm-phone', 'edits/edit-phone/confirm-phone')
    ->middleware('auth')
    ->name('confirm-phone');


Route::post('edit-phone', [phoneController::class, 'sendphone'])
    ->middleware('auth', 'throttle:phone')
    ->name('send-phone-otp');


Route::put('confirm-phone', [phoneController::class, 'updatephone'])
    ->middleware('auth', 'throttle:confirm-phone')
    ->name('update-phone');


Route::post('resend-otp-edit-phone', [phoneController::class, 'resendphone'])
    ->middleware('auth', 'throttle:phone')
    ->name('resend-phone-otp');


//? **ticket routes**



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



//? **crud routes**


//?  //delete route\\

Route::post('delete-account', [userController::class, 'deleteAccount'])
    ->middleware('auth', 'throttle:delete-account')
    ->name('delete-account');
