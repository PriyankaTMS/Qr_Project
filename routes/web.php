<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StallController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\Auth\RegisterController;

Route::get('/', [RegisterController::class, 'showRegistrationForm'])->name('home.register');

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/success', [RegisterController::class, 'success'])->name('success');
Route::get('/verify-otp/{userId}', [RegisterController::class, 'verifyOtp'])->name('verify-otp');
Route::post('/verify-otp/{userId}', [RegisterController::class, 'verifyOtpPost'])->name('verify-otp.post');
Route::get('/privacypolicy', [RegisterController::class, 'privacypolicy'])->name('privacypolicy');
Route::get('/users/id-card/{id}', [RegisterController::class, 'downloadIdCard'])->name('users.id-card');

Route::get('/user/id-card/{id}', [UserController::class, 'downloadIdCard'])->name('user.id-card');
Route::get('/users/{id}/print', [UserController::class, 'printQR'])->name('users.print');
Route::get('/download-idcard/{id}', [UserController::class, 'downloadIdCard'])
    ->name('download.idcard');

Route::middleware(['auth'])->group(function () {
Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::get('/user/create', [UserController::class, 'create'])->name('users.create');
Route::post('/user/store', [UserController::class, 'store'])->name('users.store');
Route::get('/user/edit{id}', [UserController::class, 'edit'])->name('users.edit');
Route::post('/user/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::post('/user/delete/{id}', [UserController::class, 'destroy'])->name('users.destroy');



Route::get('/stalls', [StallController::class, 'index'])->name('stalls.index');
Route::get('/stall/create', [StallController::class, 'create'])->name('stalls.create');
Route::post('/stall/store', [StallController::class, 'store'])->name('stalls.store');
Route::get('/stall/edit/{id}', [StallController::class, 'edit'])->name('stalls.edit');
Route::post('/stall/update/{id}', [StallController::class, 'update'])->name('stalls.update');
Route::post('/stall/delete/{id}', [StallController::class, 'destroy'])->name('stalls.destroy');
// Route::get('/export-visitors', [StallController::class, 'exportVisitors'])
//     ->name('stall.visitors.export');

//Route::get('/stall/visitors/export/{stall_id}', [StallController::class, 'exportVisitors'])
   // ->name('stall.visitors.export');
   Route::get('/stall-visitors-export/{stall_id}', [StallController::class, 'exportVisitors'])
    ->name('stall.visitors.export');

   Route::get('/qr-codes', [QrCodeController::class, 'index'])->name('qr-codes.index');
   Route::get('/qr-codes/create', [QrCodeController::class, 'create'])->name('qr-codes.create');
   Route::post('/qr-codes', [QrCodeController::class, 'store'])->name('qr-codes.store');
   Route::get('/qr-codes/{id}', [QrCodeController::class, 'show'])->name('qr-codes.show');
   Route::delete('/qr-codes/{id}', [QrCodeController::class, 'destroy'])->name('qr-codes.destroy');
});
