<?php


use App\Http\Controllers\Api\V1\AuthControllers\AuthController;
use App\Http\Controllers\Api\V1\AuthControllers\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(callback: function () {
    Route::post('registration', [RegistrationController::class, 'registration'])->name('registration');
    Route::post('login', [AuthController::class, 'login'])->name('login');
});
