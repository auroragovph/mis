<?php

use Illuminate\Support\Facades\Route;
use Modules\System\Http\Controllers\Acl\AccountController;
use Modules\System\Http\Controllers\Acl\PermissionController;
use Modules\System\Http\Controllers\Acl\RoleController;
use Modules\System\Http\Controllers\Auth\AuthenticatedSessionController;
use Modules\System\Http\Controllers\EmployeeController;
use Modules\System\Http\Controllers\Office\DivisionController;
use Modules\System\Http\Controllers\Office\OfficeController;
use Modules\System\Http\Controllers\ProfileController;
use Modules\System\Http\Controllers\SystemController;
use Modules\System\Http\Livewire\Auth\Login;

Route::group(['prefix' => 'login', 'middleware' => ['guest']], function () {
    Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/', [AuthenticatedSessionController::class, 'store']);
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');




Route::group(['prefix' => 'system', 'middleware' => 'auth:web', 'as' => 'sys.'], function () {


    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {

        Route::get('/', [ProfileController::class, 'index'])->name('index');

        Route::group(['prefix' => 'security', 'as' => 'security.'], function() {
            Route::patch('username', [ProfileController::class, 'change_username'])->name('username');
            Route::patch('password', [ProfileController::class, 'change_password'])->name('password');

        });
        
        Route::patch('/information', [ProfileController::class, 'information'])->name('information');
        Route::patch('/credentials', [ProfileController::class, 'credentials'])->name('credentials');
    });

    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {

        Route::get('/dashboard', [SystemController::class, 'index'])->name('dashboard');


        Route::resource('employee', EmployeeController::class);

        Route::group(['prefix' => 'acl',  'as' => 'acl.'], function () {

            Route::group(['prefix' => 'accounts',  'as' => 'account.'], function () {
                Route::get('/', [AccountController::class, 'index'])->name('index');
            });

            Route::group(['prefix' => 'role',  'as' => 'role.'], function () {
                Route::get('/', [RoleController::class, 'index'])->name('index');
            });

            Route::group(['prefix' => 'permissions',  'as' => 'perm.'], function () {
                Route::get('/', [PermissionController::class, 'index'])->name('index');
            });


        });

        Route::resource('office', OfficeController::class);
        Route::resource('division', DivisionController::class);
    });
});
