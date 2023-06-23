<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\UsersController;
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
Route::middleware('jwt.check')->group( function(){
    Route::get('bem-vindo', [UsersController::class, 'index']);
    Route::get('user/get-all', [UsersController::class, 'getAll']);
    Route::get('user/get-active', [UsersController::class, 'getActive']);
    Route::get('user/{id}', [UsersController::class, 'get']);
    Route::post('user', [UsersController::class, 'create'])->middleware('validate.users.data')->name('user');
    Route::put('user/{id}', [UsersController::class, 'update'])->middleware('validate.users.data')->name('user.update');  
    Route::delete('user/{id}', [UsersController::class, 'delete']);  
});
