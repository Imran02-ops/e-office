<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');


/*
|--------------------------------------------------------------------------
| OTP ROUTES (User sudah login tapi belum verifikasi OTP)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {

    Route::get('/otp', [AuthController::class, 'showOtpForm'])->name('otp.form');
    Route::post('/otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');

});


/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES (Login + OTP Verified)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'check.otp'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DocumentController::class, 'dashboard'])->name('dashboard');

    // Generate Document
    Route::post('/generate', [DocumentController::class, 'generate'])->name('document.generate');

    // Download PDF
    Route::get('/download/{file}', [DocumentController::class, 'download'])->name('download');

    // Rename / Update PDF
    Route::post('/document/rename', [DocumentController::class, 'rename'])->name('document.rename');

    // Delete PDF
    Route::delete('/document/delete/{filename}', [DocumentController::class, 'delete'])->name('document.delete');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


    Route::get('/generate', [DocumentController::class, 'showGenerateForm'])->name('document.generate.form');
    Route::post('/generate', [DocumentController::class, 'generate'])->name('document.generate');

});
