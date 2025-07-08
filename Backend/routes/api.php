<?php


use App\Http\Controllers\Api\V1\AuthControllers\AuthController;
use App\Http\Controllers\Api\V1\AuthControllers\ForgotPasswordController;
use App\Http\Controllers\Api\V1\AuthControllers\RegistrationController;
use App\Http\Controllers\Api\V1\ColumnsController;
use App\Http\Controllers\Api\V1\DeckController;
use App\Http\Controllers\Api\V1\FilterDataController;
use App\Http\Controllers\Api\V1\TimezoneController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(callback: function () {
    Route::middleware('guest')->group(callback: function () {
        Route::post('registration', [RegistrationController::class, 'registration'])->name('registration');
        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::prefix('auth')->group(function () {
            Route::get('{provider}/redirect', [AuthController::class, 'redirect'])->name('redirect');
            Route::get('{provider}/callback', [AuthController::class, 'handleCallback'])->name('handleCallback');
        });
        Route::prefix('password')->group(function () {
            Route::post('sendResetLink', [ForgotPasswordController::class, 'sendResetLink'])->name('sendResetLink');
            Route::post('update',[ForgotPasswordController::class, 'updatePassword'])->name('updatePassword');
        });
        /////
        Route::get('columns/{nameTable}', [ColumnsController::class, 'getColumns'])->name('getColumns');
        Route::get('filtersData/{nameTable}',[FilterDataController::class, 'getFilterData'])->name('getFilterData');
        Route::get('decks',[DeckController::class, 'getDecks'])->name('getDecks');
        Route::delete('decks/{deckId}',[DeckController::class, 'deleteDeck'])->name('deleteDeck');
    });
    Route::middleware('auth')->group(callback: function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('timezones', [TimezoneController::class, 'getTimezones'])->name('getTimezones');

    });
});
