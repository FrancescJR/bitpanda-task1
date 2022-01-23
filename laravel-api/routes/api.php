<?php


use Bitpanda\User\Infrastructure\UI\HttpControllers\DeleteUserController;
use Bitpanda\User\Infrastructure\UI\HttpControllers\ListUsersController;
use Bitpanda\User\Infrastructure\UI\HttpControllers\UpdateUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['api'])->prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::put('/{id}', UpdateUserController::class);
        Route::get('/', ListUsersController::class);
        Route::delete('/{id}', DeleteUserController::class);
    });
});
