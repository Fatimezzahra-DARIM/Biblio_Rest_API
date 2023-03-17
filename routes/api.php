<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

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

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);
});

// Route::apiResource('user',UserController::class);

Route::controller(UserController::class)->group(function () {
    Route::patch('user/update/{id}','update' );
    Route::put('user/updatePassword', 'updatePassword');

});
// Route::patch('/profil/{id}', [ProfilController::class, 'update']);
// Route::patch('user/update/{id}', [UserController::class, 'update'] );
// Route::patch('/users/{id}', 'UserController@update');
