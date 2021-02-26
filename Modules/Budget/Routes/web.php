<?php

use Illuminate\Support\Facades\Route;
use Modules\Budget\Http\Controllers\SourceOfFundsController;

Route::group(['prefix' => 'budget', 'middleware' => ['auth:web', 'specific.division:'.config('constants.office.BUDGET')], 'as' => 'budget.'], function(){
    Route::resource('source-of-funds', SourceOfFundsController::class);    
});