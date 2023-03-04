<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\ContactController;
use App\Http\Controllers\Api\v1\ContactItemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->name('api.v1.')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])
        ->name('login');

    Route::middleware(['auth:api'])->group(function () {
        Route::get('/me', [AuthController::class, 'me'])
            ->name('me');

        Route::apiResource('contact', ContactController::class);
        Route::apiResource('contact.items', ContactItemController::class);
    });

});

