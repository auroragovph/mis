<?php

use Illuminate\Support\Facades\Route;
use Modules\FileTracking\Http\Controllers\QRController;

use Modules\FileTracking\Http\Controllers\Document\{
    AttachmentController,
    DocumentController,
    RRController,
    TransmittalController
};

use Modules\FileTracking\Http\Controllers\Forms\{
    AFLController,
    CafoaController,
    DisbursementVoucherController,
    ItineraryController,
    PayrollController,
    PRController,
    TravelOrderController,
};

Route::group(['prefix' => 'file-tracking', 'middleware' => 'auth:web', 'as' => 'fts.'], function() {

    Route::group(['prefix' => 'documents', 'as' => 'documents.'], function(){

        Route::get('/',             [DocumentController::class, 'index'])       ->name('index');
        Route::get('/receipt',      [DocumentController::class, 'receipt'])     ->name('receipt');
        Route::get('/track',        [DocumentController::class, 'track'])       ->name('track');
        Route::get('/full',         [DocumentController::class, 'full'])        ->name('full');

        Route::group(['prefix' => 'attachments', 'as' => 'attach.'], function(){
            Route::get('/',         [AttachmentController::class, 'index'])     ->name('index');
            Route::post('/',        [AttachmentController::class, 'check'])     ->name('check');
            Route::get('/{id}',     [AttachmentController::class, 'form'])      ->name('form');
            Route::post('/{id}',    [AttachmentController::class, 'store'])     ->name('attach');
            Route::get('/{file}/stream', [AttachmentController::class, 'file']) ->name('file');
        });

        Route::group(['prefix' => 'receive-release', 'as' => 'rr.', 'middleware' => ['permission:fts.sa.rr']], function(){
            Route::get('/',         [RRController::class, 'index'])             ->name('index');
            Route::post('/',        [RRController::class, 'form'])              ->name('form');
            Route::put('/',         [RRController::class, 'submit'])            ->name('submit');
        });


        // Route::group(['prefix' => 'numbering', 'as' => 'number.'], function(){
        //     Route::get('/',         [NumberingController::class, 'index'])      ->name('index');
        //     Route::put('/',         [NumberingController::class, 'search'])     ->name('search');
        //     Route::post('/',        [NumberingController::class, 'number'])     ->name('number');
        // });

        Route::group(['prefix' => 'transmittal', 'as' => 'transmittal.', 'middleware' => ['permission:fts.sa.transmittal']], function(){
            Route::get('/',             [TransmittalController::class, 'index'])    ->name('index');
            Route::post('/form',        [TransmittalController::class, 'form'])     ->name('form');
            Route::post('/form/release',[TransmittalController::class, 'release'])  ->name('release');
            Route::get('/{uuid}/print', [TransmittalController::class, 'print'])    ->name('print');
            Route::post('/form/receive',[TransmittalController::class, 'form2'])    ->name('receive.form');
            Route::put('/form/receive', [TransmittalController::class, 'receive'])  ->name('receive.submit');
        });

    });

    Route::middleware(['permission:fts.document.view'])->group(function(){

        Route::resource('afl',          AFLController::class)                       ->except(['destory']);
        Route::resource('cafoa',        CafoaController::class)                     ->except(['destory']);
        Route::resource('dv',           DisbursementVoucherController::class)       ->except(['destory']);
        Route::resource('payroll',     PayrollController::class)                   ->except(['destory']);
        Route::resource('pr',           PRController::class)                        ->except(['destory']);

        Route::group(['prefix' => 'travel', 'as' => 'travel.'], function(){
            Route::resource('itinerary',ItineraryController::class)                 ->except(['destory']);
            Route::resource('order',    TravelOrderController::class)               ->except(['destory']);
        });

    });

    Route::group(['prefix', 'qr', 'as' => 'qr.'], function(){
        Route::get('/',                 [QRController::class, 'index'])             ->name('index');
        Route::post('/generate',        [QRController::class, 'generate'])          ->name('generate');
        Route::post('/print',           [QRController::class, 'print'])             ->name('print');
    });

});

// Route::get('file-tracking/kiosk', KioskController::class)->name('fts.documents.kiosk');
