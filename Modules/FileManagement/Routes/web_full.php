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
use Modules\FileManagement\Http\Controllers\Forms\Cafoa\CafoaController;
use Modules\FileManagement\Http\Controllers\Forms\Procurement\POController;
use Modules\FileManagement\Http\Controllers\Forms\Procurement\PRController;
use Modules\FileManagement\Http\Controllers\Forms\Travel\ItineraryController;
use Modules\FileManagement\Http\Controllers\Forms\Travel\TravelOrderController;

Route::group(['prefix' => 'file-management', 'middleware' => 'auth:web', 'as' => 'fms.'], function() {
    

    // Route::group(['prefix' => 'documents'], function(){

    //     Route::get('/',                     [DocumentController::class, 'index'])       ->name('fms.documents.index');
    //     Route::get('/{id}/redirect',        [DocumentController::class, 'redirect'])    ->name('fms.documents.redirect');
    //     Route::get('/{id}/receipt',         [DocumentController::class, 'receipt'])     ->name('fms.documents.receipt');
    //     Route::get('/track',                [DocumentController::class, 'track'])       ->name('fms.documents.track');


    //     Route::group(['prefix' => 'cancel', 'middleware' => 'can:fms.document.cancel'], function(){
    //         Route::get('/',                 [CancellationController::class, 'index'])   ->name('fms.documents.cancel.index');
    //         Route::post('/',                [CancellationController::class, 'check'])   ->name('fms.documents.cancel.check');
    //         Route::get('/{id}/cancel',      [CancellationController::class, 'form'])    ->name('fms.documents.cancel.form');
    //         Route::post('/{id}/cancel',     [CancellationController::class, 'submit'])  ->name('fms.documents.cancel.submit');
    //     });
        


    //     Route::group(['prefix' => 'activate', 'middleware' => 'can:fms.sa.activate'], function(){
    //         Route::get('/',                 [ActivationController::class, 'index'])     ->name('fms.documents.activation.index');
    //         Route::post('/',                [ActivationController::class, 'submit'])    ->name('fms.documents.activation.submit');
    //     });

    //     Route::group(['prefix' => 'receive-release', 'middleware' => 'can:fms.sa.rr'], function(){
    //         Route::get('/',                 [RRController::class, 'index'])             ->name('fms.documents.rr.index');
    //         Route::post('/',                [RRController::class, 'form'])              ->name('fms.documents.rr.form');
    //         Route::put('/',                 [RRController::class, 'submit'])            ->name('fms.documents.rr.submit');
    //     });

    //     Route::group(['prefix' => 'attachments', 'middleware' => 'can:fms.sa.attach'], function(){
    //         Route::get('/',                 [AttachmentController::class, 'index'])     ->name('fms.documents.attach.index');
    //         Route::post('/',                [AttachmentController::class, 'check'])     ->name('fms.documents.attach.check');
    //         Route::get('/{id}/attachments', [AttachmentController::class, 'form'])      ->name('fms.documents.attach.form');
    //         Route::post('/{id}/attachments',[AttachmentController::class, 'attach'])    ->name('fms.documents.attach.attach');
    //         Route::get('/{file}/stream',    [AttachmentController::class, 'file'])      ->name('fms.documents.attach.file');
    //     });

    //     Route::group(['prefix' => 'numbering', 'middleware' => 'fms.sa.number'], function(){
    //         Route::get('/',                 [NumberingController::class, 'index'])      ->name('fms.documents.number.index');
    //         Route::put('/',                 [NumberingController::class, 'search'])     ->name('fms.documents.number.search');
    //         Route::post('/',                [NumberingController::class, 'number'])     ->name('fms.documents.number.number');
    //     });

    // });




    Route::group(['prefix' => 'procurement', 'as' => 'procurement.'],function(){

        Route::resource('request',  PRController::class)->except(['destroy']);
        Route::resource('order',    POController::class)->except(['destroy']);


        // Route::group(['prefix' => 'request'], function(){
        //     Route::get('/',                 [PRController::class, 'index'])             ->name('fms.procurement.request.index');
        //     Route::get('/{id}/show',        [PRController::class, 'show'])              ->name('fms.procurement.request.show');
        //     Route::get('/create',           [PRController::class, 'create'])            ->name('fms.procurement.request.create')        ->middleware('can:fms.document.create');
        //     Route::post('/create',          [PRController::class, 'store'])             ->name('fms.procurement.request.store')         ->middleware('can:fms.document.create');
        //     Route::get('/{id}/edit',        [PRController::class, 'edit'])              ->name('fms.procurement.request.edit');
        //     Route::patch('/{id}/edit',      [PRController::class, 'update'])            ->name('fms.procurement.request.update');
        //     Route::get('/{id}/print',       [PRController::class, 'print'])             ->name('fms.procurement.request.print');
        // });

        // Route::group(['prefix' => 'order'], function(){
        //     Route::get('/',                 [POController::class, 'index'])             ->name('fms.procurement.order.index');
        //     Route::get('/{id}/create',      [POController::class, 'create'])            ->name('fms.procurement.order.create');
        //     Route::get('/{id}/show',        [POController::class, 'show'])              ->name('fms.procurement.order.show');
        //     Route::get('/{id}/edit',        [POController::class, 'edit'])              ->name('fms.procurement.order.edit');
        //     Route::put('/{id}/edit',        [POController::class, 'update'])            ->name('fms.procurement.order.update');
        //     Route::post('/{id}/store',      [POController::class, 'store'])             ->name('fms.procurement.order.store');
        // });

    });


    // Route::group(['prefix' => 'cafoa'],function(){
    //     Route::get('/',                     [CafoaController::class, 'index'])          ->name('fms.cafoa.index');
    //     Route::get('/create',               [CafoaController::class, 'create'])         ->name('fms.cafoa.create');
    //     Route::post('/create',              [CafoaController::class, 'store'])          ->name('fms.cafoa.store');
    //     Route::get('/{id}/show',            [CafoaController::class, 'show'])           ->name('fms.cafoa.show');
    //     Route::get('/{id}/edit',            [CafoaController::class, 'edit'])           ->name('fms.cafoa.edit');
    //     Route::get('/{id}/print',           [CafoaController::class, 'print'])          ->name('fms.cafoa.print');
    //     Route::post('/{id}/edit',           [CafoaController::class, 'update'])         ->name('fms.cafoa.update');
    // });

    

    // Route::group(['prefix' => 'travel'], function(){

    //     Route::group(['prefix' => 'order'], function(){
    //         Route::get('/',                 [TravelOrderController::class, 'index'])    ->name('fms.travel.order.index');
    //         Route::get('/create',           [TravelOrderController::class, 'create'])   ->name('fms.travel.order.create');
    //         Route::post('/store',           [TravelOrderController::class, 'store'])    ->name('fms.travel.order.store');
    //         Route::get('/{id}/show',        [TravelOrderController::class, 'show'])     ->name('fms.travel.order.show');
    //         Route::get('/{id}/edit',        [TravelOrderController::class, 'edit'])     ->name('fms.travel.order.edit');
    //         Route::post('/{id}/update',     [TravelOrderController::class, 'update'])   ->name('fms.travel.order.update');
    //         Route::get('/{to}/print',       [TravelOrderController::class, 'print'])    ->name('fms.travel.order.print');

    //     });


    //     Route::group(['prefix' => 'itinerary'], function(){
    //         Route::get('/',                 [ItineraryController::class, 'index'])      ->name('fms.travel.itinerary.index');
    //         Route::get('/create',           [ItineraryController::class, 'create'])     ->name('fms.travel.itinerary.create');
    //         Route::post('/create',          [ItineraryController::class, 'store'])      ->name('fms.travel.itinerary.store');
    //         Route::get('/{id}/show',        [ItineraryController::class, 'show'])       ->name('fms.travel.itinerary.show');
    //         Route::get('/{id}/print',       [ItineraryController::class, 'print'])      ->name('fms.travel.itinerary.print');
    //         Route::get('/{id}/edit',        [ItineraryController::class, 'edit'])       ->name('fms.travel.itinerary.edit');
    //         Route::put('/{id}/edit',        [ItineraryController::class, 'update'])     ->name('fms.travel.itinerary.update');
    //     });

    // });

    // Route::prefix('application-for-leave')->namespace('Forms')->group(function(){
    //     Route::get('/', 'AFLController@index')->name('fms.afl.index');
    //     Route::post('/create', 'AFLController@create')->name('fms.afl.create');
    //     Route::put('/create', 'AFLController@store')->name('fms.afl.store');
    //     Route::get('/{id}/show', 'AFLController@show')->name('fms.afl.show');
    //     Route::get('/{id}/edit', 'AFLController@edit')->name('fms.afl.edit');
    //     Route::get('/{id}/print', 'AFLController@print')->name('fms.afl.print');
    //     Route::patch('/{id}/edit', 'AFLController@update')->name('fms.afl.update');
    // });



    

});