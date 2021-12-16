<?php

use Illuminate\Support\Facades\Route;
use Modules\FileManagement\core\Http\Controllers\DashboardController;

Route::group(['prefix' => 'file-management', 'as' => 'fms.', 'middleware' => 'auth:web'], function(){
    Route::get('dashboard', DashboardController::class)->name('dashboard');
});
