<?php

use Illuminate\Support\Facades\Route;
use Modules\HumanResource\core\Http\Controllers\DashboardController;
use Modules\HumanResource\core\Http\Controllers\Employee\EmployeeController;

Route::group(['prefix' => 'human-resource', 'as' => 'hrm.'], function(){

    Route::get('', DashboardController::class)->name('dashboard');

    Route::resource('employee', EmployeeController::class);

});
