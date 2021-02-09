<?php

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'file-management', 'middleware' => 'auth:web'], function() {
    

    Route::prefix('documents')->namespace('Document')->group(function(){

        Route::get('/', 'DocumentController@index')->name('fms.documents.index');
        Route::get('/{id}/redirect', 'DocumentController@redirect')->name('fms.documents.redirect');
        Route::get('/{id}/receipt', 'DocumentController@receipt')->name('fms.documents.receipt');
        Route::get('/track', 'DocumentController@track')->name('fms.documents.track');


        Route::group(['prefix' => 'cancel'], function(){
            Route::get('/', 'CancellationController@index')->name('fms.documents.cancel.index');
            Route::post('/', 'CancellationController@check')->name('fms.documents.cancel.check');
            Route::get('/{id}/cancel', 'CancellationController@form')->name('fms.documents.cancel.form');
            Route::post('/{id}/cancel', 'CancellationController@submit')->name('fms.documents.cancel.submit');
        });
        


        Route::group(['prefix' => 'activate'], function(){
            Route::get('/', 'ActivationController@index')->name('fms.documents.activation.index');
            Route::post('/', 'ActivationController@submit')->name('fms.documents.activation.submit');
        });

        Route::group(['prefix' => 'receive-release'], function(){
            Route::get('/', 'RRController@index')->name('fms.documents.rr.index');
            Route::post('/', 'RRController@form')->name('fms.documents.rr.form');
            Route::put('/', 'RRController@submit')->name('fms.documents.rr.submit');
        });



        Route::group(['prefix' => 'attachments'], function(){
            Route::get('/', 'AttachmentController@index')->name('fms.documents.attach.index');
            Route::post('/', 'AttachmentController@check')->name('fms.documents.attach.check');
            Route::get('/{id}/attachments', 'AttachmentController@form')->name('fms.documents.attach.form');
            Route::post('/{id}/attachments', 'AttachmentController@attach')->name('fms.documents.attach.attach');
            Route::get('/{file}/stream', 'AttachmentController@file')->name('fms.documents.attach.file');

        });


       

        Route::group(['prefix' => 'numbering'], function(){
            Route::get('/', 'NumberingController@index')->name('fms.documents.number.index');
            Route::put('/', 'NumberingController@search')->name('fms.documents.number.search');
            Route::post('/', 'NumberingController@number')->name('fms.documents.number.number');
        });

    });




    Route::prefix('procurement')->namespace('Forms\Procurement')->group(function(){

        Route::get('/', 'ProcurementController@index')->name('fms.procurement.index');
        Route::post('/lists', 'ProcurementController@lists');

        Route::prefix('request')->group(function(){
            Route::get('/', 'PRController@index')->name('fms.procurement.request.index');
            Route::get('/{id}/show', 'PRController@show')->name('fms.procurement.request.show');
            Route::get('/create', 'PRController@create')->name('fms.procurement.request.create');
            Route::post('/create', 'PRController@store')->name('fms.procurement.request.store');
            Route::get('/{id}/edit', 'PRController@edit')->name('fms.procurement.request.edit');
            Route::patch('/{id}/edit', 'PRController@update')->name('fms.procurement.request.update');
            Route::get('/{id}/print', 'PRController@print')->name('fms.procurement.request.print');
        });

        Route::prefix('order')->group(function(){
            Route::get('/', 'POController@index')->name('fms.procurement.order.index');
            Route::get('/{id}/create', 'POController@create')->name('fms.procurement.order.create');
            Route::get('/{id}/show', 'POController@show')->name('fms.procurement.order.show');
            Route::get('/{id}/edit', 'POController@edit')->name('fms.procurement.order.edit');
            Route::put('/{id}/edit', 'POController@update')->name('fms.procurement.order.update');
            Route::post('/{id}/store', 'POController@store')->name('fms.procurement.order.store');
        });

    });


    Route::prefix('cafoa')->namespace('Forms\Cafoa')->group(function(){
        Route::get('/', 'CafoaController@index')->name('fms.cafoa.index');
        Route::get('/create', 'CafoaController@create')->name('fms.cafoa.create');
        Route::post('/create', 'CafoaController@store')->name('fms.cafoa.store');
        Route::get('/{id}/show', 'CafoaController@show')->name('fms.cafoa.show');
        Route::get('/{id}/edit', 'CafoaController@edit')->name('fms.cafoa.edit');
        Route::get('/{id}/print', 'CafoaController@print')->name('fms.cafoa.print');
        Route::post('/{id}/edit', 'CafoaController@update')->name('fms.cafoa.update');
    });

    

    Route::prefix('travel')->namespace('Forms\Travel')->group(function(){

        Route::prefix('order')->group(function(){
            Route::get('/', 'TravelOrderController@index')->name('fms.travel.order.index');
            Route::post('/lists', 'TravelOrderController@lists');
            Route::get('/create', 'TravelOrderController@create')->name('fms.travel.order.create');
            Route::post('/store', 'TravelOrderController@store')->name('fms.travel.order.store');
            Route::get('/{id}/show', 'TravelOrderController@show')->name('fms.travel.order.show');
            Route::get('/{id}/edit', 'TravelOrderController@edit')->name('fms.travel.order.edit');
            Route::post('/{id}/update', 'TravelOrderController@update')->name('fms.travel.order.update');
            Route::get('/{to}/print', 'TravelOrderController@print')->name('fms.travel.order.print');

        });


        Route::prefix('itinerary')->group(function(){
            Route::get('/', 'ItineraryController@index')->name('fms.travel.itinerary.index');
            Route::get('/create', 'ItineraryController@create')->name('fms.travel.itinerary.create');
            Route::post('/create', 'ItineraryController@store')->name('fms.travel.itinerary.store');
            Route::get('/{id}/show', 'ItineraryController@show')->name('fms.travel.itinerary.show');
            Route::get('/{id}/print', 'ItineraryController@print')->name('fms.travel.itinerary.print');
            Route::get('/{id}/edit', 'ItineraryController@edit')->name('fms.travel.itinerary.edit');
            Route::put('/{id}/edit', 'ItineraryController@update')->name('fms.travel.itinerary.update');
        });

    });


    Route::prefix('application-for-leave')->namespace('Forms')->group(function(){
        Route::get('/', 'AFLController@index')->name('fms.afl.index');
        Route::post('/create', 'AFLController@create')->name('fms.afl.create');
        Route::put('/create', 'AFLController@store')->name('fms.afl.store');
        Route::get('/{id}/show', 'AFLController@show')->name('fms.afl.show');
        Route::get('/{id}/edit', 'AFLController@edit')->name('fms.afl.edit');
        Route::get('/{id}/print', 'AFLController@print')->name('fms.afl.print');
        Route::patch('/{id}/edit', 'AFLController@update')->name('fms.afl.update');
    });


    

});