<?php

use Illuminate\Support\Facades\Route;
use Modules\System\Http\Controllers\AccountController;
use Modules\System\Http\Controllers\ACL\PermissionController;
use Modules\System\Http\Controllers\ACL\RoleController;
use Modules\System\Http\Controllers\Office\DivisionController;
use Modules\System\Http\Controllers\Office\OfficeController;
use Modules\System\Http\Controllers\SpecialPages\FirstLoginController;

Route::group(['prefix' => 'system', 'as' => 'sys.', 'middleware' => ['auth:web']], function(){

    Route::group(['prefix' => 'office', 'as' => 'office.'], function(){

        Route::resource('/',            OfficeController::class)                ->except(['destroy']);

        Route::group(['prefix' => 'division', 'as' => 'division.'], function(){
            Route::resource('/',        DivisionController::class)              ->except(['destroy']);
        });

    });


    Route::group(['prefix' => 'accounts', 'as' => 'account.'],function(){
        Route::get('/',                 [AccountController::class, 'index'])    ->name('index');
        Route::post('/{account}/acl',   [AccountController::class, 'acl'])      ->name('acl.update');
    });

    Route::group(['prefix' => 'acl', 'as' => 'acl.'], function(){
        Route::resource('permission',   PermissionController::class)                ->except(['destroy']);
        Route::resource('role',         RoleController::class)                      ->except(['destroy']);
    });

});


Route::group(['prefix' => 'special-pages','middleware' => 'auth:web'], function(){

    Route::group(['prefix' => 'login'], function(){
        Route::get('/first-login',              [FirstLoginController::class, 'index'])     ->name('sp.login.first')        ->middleware('sp-firstlogin');
        Route::post('/{employee}/first-login',  [FirstLoginController::class, 'submit'])    ->name('sp.login.first.post')   ->middleware('sp-firstlogin');
    });

});