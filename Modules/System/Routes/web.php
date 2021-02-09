<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'system', 'middleware' => ['auth:web']], function(){

    Route::get('/', 'SystemController@index');
    
    // Route::get('/', function(){
    //     return redirect(route('sys.dashboard'));
    // });

    Route::get('/dashboard', 'DashboardController@index')->name('sys.dashboard');


    Route::prefix('office')->namespace('Office')->group(function(){

        Route::get('/', 'OfficeController@index')->name('sys.office.index');
        Route::post('/', 'OfficeController@store')->name('sys.office.store');

        Route::prefix('division')->group(function(){
            Route::get('/', 'DivisionController@index')->name('sys.office.division.index');
            Route::get('/lists', 'DivisionController@lists')->middleware('only.ajax')->name('sys.office.division.lists');
            Route::post('/', 'DivisionController@store')->name('sys.office.division.store');
        });

    });


    Route::prefix('accounts')->group(function(){
        Route::get('/', 'AccountController@index')->name('sys.account.index');
        Route::post('/{account}/acl', 'AccountController@acl')->name('sys.account.acl.update');
    });

    Route::prefix('acl')->namespace('ACL')->group(function(){


        Route::prefix('permission')->group(function(){
            Route::get('/', 'PermissionController@index')->name('sys.acl.permission.index');
            Route::get('/lists', 'PermissionController@lists')->name('sys.acl.permission.lists');
        });

        Route::prefix('role')->group(function(){
            Route::get('/', 'RoleController@index')->name('sys.acl.role.index');
            Route::post('/', 'RoleController@store')->name('sys.acl.role.store');

            Route::get('/lists', 'RoleController@lists')->name('sys.acl.role.lists');
        });

    });

});


Route::group([
    'prefix' => 'special-pages',
    'middleware' => 'auth:web',
    'namespace' => 'SpecialPages'
], function(){

    Route::prefix('login')->group(function(){
        Route::get('/first-login', 'FirstLoginController@index')->name('sp.login.first')->middleware('sp-firstlogin');
        Route::post('/{employee}/first-login', 'FirstLoginController@submit')->name('sp.login.first.post')->middleware('sp-firstlogin');
    });

});