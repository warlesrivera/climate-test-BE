<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Authentication\LoginController;
use App\Http\Controllers\Authentication\AuthController;

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


Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [LoginController::class, 'login']);
});

Route::group(['prefix' => 'users'], function () {
    Route::post('/create', [UserController::class, 'store']);
});

Route::group(["middleware" => ['auth:api']], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/get/{user}', [UserController::class, 'show']);
        Route::post('/update/{user}', [UserController::class, 'update']);
        Route::post('/delete/{id}', [UserController::class, 'destroy']);
    });
});
