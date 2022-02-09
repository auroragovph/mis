<?php

use Illuminate\Support\Facades\Route;
use Modules\FileManagement\core\Http\Controllers\DashboardController;
use Modules\FileManagement\core\Http\Controllers\Document\ActivateController;
use Modules\FileManagement\core\Http\Controllers\Document\AttachmentController;
use Modules\FileManagement\core\Http\Controllers\Document\RRController;
use Modules\FileManagement\core\Http\Controllers\Document\TrackingController;
use Modules\FileManagement\core\Http\Controllers\Procurement\PPMPController;
use Modules\FileManagement\core\Http\Controllers\Procurement\PurchaseOrderController;
use Modules\FileManagement\core\Http\Controllers\Procurement\PurchaseRequestController;
use Modules\FileManagement\core\Http\Controllers\Procurement\SupplierController;
use Modules\FileManagement\core\Http\Controllers\Travel\OrderController;

Route::group(['prefix' => 'file-management', 'as' => 'fms.', 'middleware' => 'auth:web'], function () {

    Route::get('dashboard', DashboardController::class)->name('dashboard');

    Route::group(['prefix' => 'document', 'as' => 'document.'], function () {

        Route::group([
            'prefix'     => 'attachments',
            'as'         => 'attach.',
            'controller' => AttachmentController::class,
        ], function () {
            Route::get('', 'index')->name('index');
            Route::post('', 'check')->name('check');
            Route::get('/hardcopy', 'hardcopy')->name('hardcopy');
            Route::post('/hardcopy', 'attach')->name('attach');
            Route::get('/file/{url}', 'file')->name('file');
        });

        Route::group([
            'prefix'     => 'activate',
            'as'         => 'activate.',
            'controller' => ActivateController::class,
        ], function () {
            Route::get('', 'index')->name('index');
            Route::post('', 'submit')->name('submit');
        });

        Route::group([
            'prefix'     => 'receive-release',
            'as'         => 'rr.',
            'controller' => RRController::class,
        ], function () {
            Route::get('', 'index')->name('index');
            Route::post('', 'form')->name('form');
            Route::put('', 'submit')->name('submit');
        });

        Route::get('track', TrackingController::class)->name('track');
    });

    Route::group(['prefix' => 'procurement', 'as' => 'procurement.'], function () {
        Route::group(['prefix' => 'management-plan', 'as' => 'ppmp.'], function () {
            Route::get('/', [PPMPController::class, 'index'])->name('index');
        });
        Route::resource('/request', PurchaseRequestController::class)->except(['destroy'])->parameters(['' => 'id']);
        Route::resource('/order', PurchaseOrderController::class)->except(['destroy'])->parameters(['' => 'id']);
        Route::resource('/supplier', SupplierController::class);
    });

    Route::group(['prefix' => 'travel', 'as' => 'travel.'], function () {
        Route::resource('order', OrderController::class);
    });

});
