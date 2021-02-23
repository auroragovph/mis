<?php

use Illuminate\Support\Facades\Route;

use Modules\FileManagement\Http\Controllers\Document\{
    ActivationController,
    AttachmentController,
    CancellationController,
    DocumentController,
    NumberingController,
    RRController
};
use Modules\FileManagement\Http\Controllers\Forms\{
    AFLController,
    Cafoa\CafoaController,
    Procurement\POController,
    Procurement\PRController,
    Travel\ItineraryController,
    Travel\TravelOrderController
};

Route::group(['prefix' => 'file-management', 'middleware' => 'auth:web', 'as' => 'fms.'], function() {

    Route::group(['prefix' => 'documents', 'as' => 'documents.'], function(){

            Route::get('/',                     [DocumentController::class, 'index'])       ->name('index');
            Route::get('/{id}/redirect',        [DocumentController::class, 'redirect'])    ->name('redirect');
            Route::get('/{id}/receipt',         [DocumentController::class, 'receipt'])     ->name('receipt');
            Route::get('/track',                [DocumentController::class, 'track'])       ->name('track');
    
            Route::group(['prefix' => 'cancel', 'middleware' => 'can:fms.document.cancel', 'as' => 'cancel.'], function(){
                Route::get('/',                 [CancellationController::class, 'index'])   ->name('index');
                Route::post('/',                [CancellationController::class, 'check'])   ->name('check');
                Route::get('/{id}/cancel',      [CancellationController::class, 'form'])    ->name('form');
                Route::post('/{id}/cancel',     [CancellationController::class, 'submit'])  ->name('submit');
            });
    
            Route::group(['prefix' => 'activate', 'middleware' => 'can:fms.sa.activate', 'as' => 'activation.'], function(){
                Route::get('/',                 [ActivationController::class, 'index'])     ->name('index');
                Route::post('/',                [ActivationController::class, 'submit'])    ->name('submit')    ->middleware('only.ajax');
            });
    
            Route::group(['prefix' => 'receive-release', 'middleware' => 'can:fms.sa.rr', 'as' => 'rr.'], function(){
                Route::get('/',                 [RRController::class, 'index'])             ->name('index');
                Route::post('/',                [RRController::class, 'form'])              ->name('form');
                Route::put('/',                 [RRController::class, 'submit'])            ->name('submit');
            });
    
            Route::group(['prefix' => 'attachments', 'middleware' => 'can:fms.sa.attach', 'as' => 'attach.'], function(){
                Route::get('/',                 [AttachmentController::class, 'index'])     ->name('index');
                Route::post('/',                [AttachmentController::class, 'check'])     ->name('check');
                Route::get('/{id}/attachments', [AttachmentController::class, 'form'])      ->name('form');
                Route::post('/{id}/attachments',[AttachmentController::class, 'attach'])    ->name('attach');
                Route::get('/{file}/stream',    [AttachmentController::class, 'file'])      ->name('file');
            });
    
            Route::group(['prefix' => 'numbering', 'middleware' => 'can:fms.sa.number', 'as' => 'number.'], function(){
                Route::get('/',                 [NumberingController::class, 'index'])      ->name('index');
                Route::put('/',                 [NumberingController::class, 'search'])     ->name('search');
                Route::post('/',                [NumberingController::class, 'number'])     ->name('number');
            });
    });

    Route::group(['prefix' => 'procurement', 'as' => 'procurement.'],function(){

        Route::group(['prefix' => 'request', 'as' => 'request.'], function(){
            Route::resource('/',                PRController::class)                ->except(['destroy'])    ->parameters(['' => 'id']);
            Route::get('/{id}/print',           [PRController::class, 'print'])     ->name('print');
        });

        Route::group(['prefix' => 'order', 'as' => 'order.'], function(){
            Route::resource('/',        POController::class)                ->except(['destroy'])       ->parameters(['' => 'id']);
            Route::get('/{id}/print',  [POController::class, 'print'])     ->name('print');

        });

    });
    
    Route::group(['prefix' => 'cafoa', 'as' => 'cafoa.'],function(){
        Route::resource('/',                CafoaController::class)             ->except(['destroy'])   ->parameters(['' => 'id']);
        Route::get('/{id}/print',           [CafoaController::class, 'print'])  ->name('print');
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