<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'human-resource', 'middleware' => ['auth:web', 'specific.division:'.config('constants.office.HRMO')], 'as' => 'hrm.'], function(){

   

});