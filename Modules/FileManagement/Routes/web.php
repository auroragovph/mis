<?php

use Illuminate\Support\Facades\Route;
use Modules\FileManagement\Http\Controllers\DashboardController;
use Modules\FileManagement\Http\Controllers\Document\{
    ActivationController,
    AttachmentController,
    CancellationController,
    DocumentController,
    NumberingController,
    RRController,
    TrackingController
};
use Modules\FileManagement\Http\Controllers\Forms\{
    AFLController,
    Cafoa\CafoaController,
    
    Procurement\POController,
    Procurement\PRController,
    Procurement\IARController,
    Procurement\ConsolidationController,
    Procurement\ProcurementController,
    Procurement\CafoaController as ProcurementCafoaController,

    Travel\ItineraryController,
    Travel\TravelOrderController
};
use Modules\FileManagement\Http\Controllers\Forms\Procurement\AirController;

Route::group(['prefix' => 'file-management', 'middleware' => 'auth:web', 'as' => 'fms.'], function() {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::group(['prefix' => 'documents', 'as' => 'documents.'], function(){

            Route::get('/',                     [DocumentController::class, 'index'])       ->name('index');
            Route::get('/{id}/redirect',        [DocumentController::class, 'redirect'])    ->name('redirect');
            Route::get('/{id}/receipt',         [DocumentController::class, 'receipt'])     ->name('receipt');

            Route::get('/track',                TrackingController::class)                  ->name('track');
    
            Route::group(['prefix' => 'cancel', 'middleware' => 'can:fms.document.cancel', 'as' => 'cancel.'], function(){
                Route::get('/',         [CancellationController::class, 'index'])   ->name('index');
                Route::get('/form',     [CancellationController::class, 'form'])    ->name('form');
                Route::post('/form',    [CancellationController::class, 'submit'])  ->name('submit');
            });
    
            Route::group(['prefix' => 'activate', 'middleware' => 'can:fms.sa.activate', 'as' => 'activation.'], function(){
                Route::get('/',                 [ActivationController::class, 'index'])     ->name('index');
                Route::post('/',                [ActivationController::class, 'submit'])    ->name('submit');
            });
    
            Route::group(['prefix' => 'receive-release', 'middleware' => 'can:fms.sa.rr', 'as' => 'rr.'], function(){
                Route::get('/',     [RRController::class, 'index'])     ->name('index');
                Route::post('/',    [RRController::class, 'form'])      ->name('form');
                Route::put('/',     [RRController::class, 'submit'])    ->name('submit');
            });
            
    
            Route::group(['prefix' => 'attachments', 'middleware' => 'can:fms.sa.attach', 'as' => 'attach.'], function(){
                Route::get('/',                 [AttachmentController::class, 'index'])     ->name('index');
                Route::post('/',                [AttachmentController::class, 'check'])     ->name('check');
                Route::get('/hardcopy',         [AttachmentController::class, 'hardcopy'])  ->name('hardcopy');
                Route::post('/hardcopy',        [AttachmentController::class, 'attach'])    ->name('attach');

                Route::get('/file/{url}',       [AttachmentController::class, 'file'])      ->name('file');

            });


    
            Route::group(['prefix' => 'numbering', 'middleware' => 'can:fms.sa.number', 'as' => 'number.'], function(){
                Route::get('/',                 [NumberingController::class, 'index'])      ->name('index');
                Route::put('/',                 [NumberingController::class, 'search'])     ->name('search');
                Route::post('/',                [NumberingController::class, 'number'])     ->name('number');
            });
    });

    Route::group(['prefix' => 'forms'], function(){

        Route::group(['prefix' => 'procurement', 'as' => 'procurement.'],function(){

            Route::get('/',                         [ProcurementController::class, 'index'])    ->name('index');
    
            Route::group(['prefix' => 'request', 'as' => 'request.'], function(){
                Route::resource('/',                PRController::class)                ->except(['destroy'])    ->parameters(['' => 'id']);
                Route::get('/{id}/print',           [PRController::class, 'print'])     ->name('print');
            });
    
            Route::group(['prefix' => 'order', 'as' => 'order.'], function(){
                Route::resource('/',        POController::class)                ->except(['destroy'])       ->parameters(['' => 'id']);
                Route::get('/{id}/print',  [POController::class, 'print'])     ->name('print');
            });
           
            Route::group(['prefix' => 'consolidate', 'as' => 'consolidate.'], function(){
                Route::get('/',             [ConsolidationController::class, 'index'])  ->name('index');
                Route::post('/',            [ConsolidationController::class, 'check'])  ->name('check');
                Route::post('/form',        [ConsolidationController::class, 'form'])   ->name('form');
                Route::post('/consolidate', [ConsolidationController::class, 'store'])  ->name('store');
            });
    
            Route::group(['prefix' => 'air', 'as' => 'air.'],function(){
                Route::resource('/',    AirController::class)   ->except(['destroy'])   ->parameters(['' => 'id']);
            });
    
        });
        
        Route::group(['prefix' => 'cafoa', 'as' => 'cafoa.'],function(){
            Route::resource('/',                CafoaController::class)             ->except(['destroy'])   ->parameters(['' => 'id']);
        });
    
        Route::group(['prefix' => 'travel', 'as' => 'travel.'],function(){
    
            Route::group(['prefix' => 'order', 'as' => 'order.'], function(){
                Route::resource('/',                TravelOrderController::class)   ->except(['destroy'])   ->parameters(['' => 'id']);
                Route::get('/{id}/print',           [TravelOrderController::class, 'print'])                ->name('print');
            });
    
            Route::group(['prefix' => 'itinerary', 'as' => 'itinerary.'], function(){
                Route::resource('/',                ItineraryController::class)     ->except(['destroy'])    ->parameters(['' => 'id']);
                Route::get('/{id}/print',           [ItineraryController::class, 'print'])                   ->name('print');
            });
    
           
    
        });
    
        Route::group(['prefix' => 'application-for-leave', 'as' => 'afl.'],function(){
            Route::resource('/',         AFLController::class)                  ->except(['destroy'])       ->parameters(['' => 'id']);
            Route::get('/{id}/print',   [AFLController::class, 'print'])        ->name('print');
        });

    });

});