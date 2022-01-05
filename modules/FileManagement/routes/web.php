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

        Route::group(['prefix' => 'attachments', 'as' => 'attach.'], function () {
            Route::get('/', [AttachmentController::class, 'index'])->name('index');
            Route::post('/', [AttachmentController::class, 'check'])->name('check');
            Route::get('/hardcopy', [AttachmentController::class, 'hardcopy'])->name('hardcopy');
            Route::post('/hardcopy', [AttachmentController::class, 'attach'])->name('attach');

            Route::get('/file/{url}', [AttachmentController::class, 'file'])->name('file');

        });

        Route::group(['prefix' => 'activate', 'as' => 'activate.'], function () {
            Route::get('/', [ActivateController::class, 'index'])->name('index');
            Route::post('/', [ActivateController::class, 'submit'])->name('submit');
        });

        Route::group(['prefix' => 'receive-release', 'as' => 'rr.'], function () {
            Route::get('/', [RRController::class, 'index'])->name('index');
            Route::post('/', [RRController::class, 'form'])->name('form');
            Route::put('/', [RRController::class, 'submit'])->name('submit');
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
