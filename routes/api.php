<?php

use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TypesController;

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
    Route::post('register', [AuthController::class,'register']);
    Route::post('me', [AuthController::class,'me']);
    Route::post('reset-password', [AuthController::class,'resetPassword']);
    Route::post('reset', [AuthController::class, 'reset']);
    Route::get('book/{request}', [BookController::class, 'show']);
    Route::get('book/', [BookController::class, 'index']);
});

Route::controller(UserController::class)->group(function () {
    Route::patch('user/update/{id}','update' );
    Route::put('user/updatePassword', 'updatePassword');

});

Route::group([
    'middleware' => ['api', 'is_admin'],
    'prefix' => 'admin',
], function () {
    Route::apiResource('Type', TypesController::class);
    Route::apiResource('Book/admin', AdminController::class);

    Route::put('role/{id}', [RoleController::class, 'role']);
    // Route::delete('Book/{id}', [AdminController::class, 'destroy']);
    // Route::put('Book/{id}', [AdminController::class, 'update']);
});
Route::group([
    'middleware' => ['api', 'recep'],
    'prefix' => 'recep',
], function () {
    Route::apiResource('Book', BookController::class);
});