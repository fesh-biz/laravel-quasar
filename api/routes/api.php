<?php


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

use App\Http\Controllers\Auth\AuthController;

Route::middleware('auth:api')->namespace('Auth')->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('logout', [AuthController::class, 'logout']);
});
