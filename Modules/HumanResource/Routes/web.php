<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'human-resource', 'middleware' => ['auth:web', 'permission:godmode']], function(){
    
    Route::get('/dashboard', 'DashboardController@index')->name('hrm.dashboard');

    Route::prefix('employee')->namespace('Employee')->group(function(){
        Route::get('/', "EmployeeController@index")->name('hrm.employee.index');
        Route::get('/create', "EmployeeController@create")->name('hrm.employee.create');
        Route::post('/create', "EmployeeController@store")->name('hrm.employee.store');

        Route::get('/{id}/edit', "EmployeeController@edit")->name('hrm.employee.edit');
        Route::post('/{id}/edit', "EmployeeController@update")->name('hrm.employee.update');
    });

    Route::prefix('plantilla')->namespace('Plantilla')->group(function(){

        Route::prefix('position')->group(function(){
            Route::get('/', 'PositionController@index')->name('hrm.plantilla.position.index');
            Route::get('/lists', 'PositionController@lists')->name('hrm.plantilla.position.lists');
        });
        Route::prefix('salary-grade')->group(function(){
            Route::get('/', 'SalaryGradeController@index')->name('hrm.plantilla.sg.index');
        });

    });

});