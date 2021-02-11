<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'system', 'middleware' => ['auth:web']], function(){
    
});