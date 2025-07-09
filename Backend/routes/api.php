<?php


use App\Http\Controllers\Api\V1\AuthControllers\AuthController;
use App\Http\Controllers\Api\V1\AuthControllers\ForgotPasswordController;
use App\Http\Controllers\Api\V1\AuthControllers\RegistrationController;
use App\Http\Controllers\Api\V1\ColumnsController;
use App\Http\Controllers\Api\V1\DeckController;
use App\Http\Controllers\Api\V1\FilterDataController;
use App\Http\Controllers\Api\V1\UserTestResultController;
use App\Http\Controllers\Api\V1\TimezoneController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(callback: function () {

    Route::prefix('decks')->group(function () {
        Route::get('/',[DeckController::class, 'getDecks'])->name('getDecks');
        Route::get('/{id}',[DeckController::class, 'getDeck'])->name('getDeck');
    });

    Route::middleware('guest:sanctum')->group(callback: function () {
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

    });
    Route::middleware('auth:sanctum')->group(callback: function () {
        Route::post('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('timezones', [TimezoneController::class, 'getTimezones'])->name('getTimezones');

        /////
        Route::get('columns/{nameTable}', [ColumnsController::class, 'getColumns'])->name('getColumns');
        Route::get('filtersData/{nameTable}',[FilterDataController::class, 'getFilterData'])->name('getFilterData');

        Route::prefix('tests')->group(function () {
            Route::post('/start',[UserTestResultController::class, 'start'])->name('startTest');
            Route::post('/end',[UserTestResultController::class, 'end'])->name('endTest');
        });
        Route::prefix('decks')->group(function () {
            Route::delete('/{id}',[DeckController::class, 'deleteDeck'])->name('deleteDeck');
        });

    });
});
