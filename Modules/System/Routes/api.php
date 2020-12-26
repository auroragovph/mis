<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'system', 'middleware' => ['auth:web']], function(){

    Route::prefix('office')->namespace('Office')->group(function(){

        Route::get('/', 'OfficeController@index')->name('api.sys.office.index');

        Route::prefix('division')->group(function(){
            Route::get('/lists', 'DivisionController@lists')->name('api.sys.office.division.index');
        });

    });

});