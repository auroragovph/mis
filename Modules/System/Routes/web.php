<?php

use Illuminate\Support\Facades\Route;
use Modules\System\Http\Controllers\Auth\AuthenticatedSessionController;


Route::group(['prefix' => 'login', 'middleware' => ['guest']], function(){
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');


Route::prefix('system')->group(function() {
    Route::get('/', 'SystemController@index');
});
