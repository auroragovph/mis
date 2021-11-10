<?php

use Illuminate\Support\Facades\Route;
use Modules\HumanResource\Http\Controllers\Employee\EmployeeController;
use Modules\HumanResource\Http\Controllers\Plantilla\PositionController;
use Modules\HumanResource\Http\Controllers\Plantilla\SalaryGradeController;

Route::group(['prefix' => 'human-resource', 'middleware' => ['auth:web', 'specific.division:'.config('constants.office.HRMO')], 'as' => 'hrm.'], function(){

    Route::resource('employee',            EmployeeController::class)           ->except(['destory']);

    Route::group(['prefix' => 'plantilla', 'as' => 'plantilla.'], function(){
        Route::resource('position',         PositionController::class)          ->except(['destroy']);
        Route::resource('salary-grade',     SalaryGradeController::class)       ->except(['destroy']);
    });

});