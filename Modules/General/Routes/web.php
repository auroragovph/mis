<?php

use Illuminate\Support\Facades\Route;
use Modules\General\Http\Controllers\MessengerController;
use Modules\General\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['prefix' => 'general', 'as' => 'general.', 'middleware' => ['auth:web']], function(){


    Route::group(['prefix' => 'messenger', 'as' => 'messenger.'], function(){
        Route::get('/', [MessengerController::class, 'index'])  ->name('index');
    });


    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function(){
        Route::get('/', [ProfileController::class, 'index'])  ->name('index');
        Route::patch('/credentials',    [ProfileController::class, 'credentials'])  ->name('credentials');
    });

});
