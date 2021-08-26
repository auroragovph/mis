<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Modules\System\Http\Controllers\Api\v1\Office\DivisionController;

Route::group(['prefix' => 'system', 'middleware' => 'auth:web', 'as' => 'api.sys.'], function(){


    Route::group(['prefix' => 'office', 'as' => 'office.'], function(){
        
        Route::resource('division', DivisionController::class);

    });

});