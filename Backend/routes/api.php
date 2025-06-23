<?php


use App\Http\Controllers\Api\V1\AuthControllers\AuthController;
use App\Http\Controllers\Api\V1\AuthControllers\RegistrationController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(callback: function () {
    Route::middleware('guest')->group(callback: function () {
        Route::post('registration', [RegistrationController::class, 'registration'])->name('registration');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::prefix('auth')->group(function () {
            Route::get('/{provider}/redirect', [AuthController::class, 'redirect'])->name('redirect');
            Route::get('/{provider}/callback', [AuthController::class, 'handleCallback'])->name('handleCallback');
        });
    });
    Route::middleware('auth')->group(callback: function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    });
});
