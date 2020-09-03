<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'file-management', 'middleware' => 'auth:web'], function() {

    Route::get('/', function(){
        return redirect(route('fms.dashboard'));
    })->name('fms.root');

    Route::get('/dashboard', 'DashboardController@index')->name('fms.dashboard');

    Route::prefix('documents')->namespace('Document')->group(function(){

        Route::get('/', 'DocumentController@index')->name('fms.documents.index');

        Route::get('/{id}/redirect', 'DocumentController@redirect')->name('fms.documents.redirect');
        Route::get('/{id}/cancel', 'DocumentController@cancel')->name('fms.documents.cancel');
        Route::post('/{id}/cancel', 'DocumentController@cancel2')->name('fms.documents.cancel2');



        Route::group(['prefix' => 'activate'], function(){
            Route::get('/', 'ActivationController@index')->name('fms.documents.activate');
            Route::post('/', 'ActivationController@info')->name('fms.documents.activation');
        });

        Route::group(['prefix' => 'receive-release', 'middleware' => ['permission:fms.sa.rr|sys.sudo']], function(){
            Route::get('/', 'RRController@index')->name('fms.documents.rr.index');
            Route::post('/', 'RRController@form')->name('fms.documents.rr.form');
            Route::put('/', 'RRController@submit')->name('fms.documents.rr.submit');
        });



        Route::group(['prefix' => 'attachments'], function(){
            Route::get('/', 'AttachmentController@index')->name('fms.documents.attach.index');
            Route::post('/', 'AttachmentController@check')->name('fms.documents.attach.check');
            Route::get('/{id}/attachments', 'AttachmentController@form')->name('fms.documents.attach.form');
            Route::post('/{id}/attachments', 'AttachmentController@attach')->name('fms.documents.attach.attach');
        });


       

        Route::group(['prefix' => 'numbering'], function(){
            Route::get('/', 'NumberingController@index')->name('fms.documents.number.index');
            Route::put('/', 'NumberingController@search')->name('fms.documents.number.search');
            Route::post('/', 'NumberingController@number')->name('fms.documents.number.number');
        });


        Route::prefix('track')->group(function(){
            Route::get('/', 'TrackingController@track')->name('fms.documents.track');
        });



    });




    Route::prefix('procurement')->namespace('Forms\Procurement')->group(function(){

        Route::get('/', 'ProcurementController@index')->name('fms.procurement.index');
        Route::post('/lists', 'ProcurementController@lists');

        Route::prefix('request')->group(function(){

            Route::get('/', 'PurchaseRequestController@index')->name('fms.procurement.request.index');
            Route::post('/lists', 'PurchaseRequestController@lists')->name('fms.procurement.request.lists');
            Route::get('/{id}/show', 'PurchaseRequestController@show')->name('fms.procurement.request.show');
            
            Route::get('/create', 'PurchaseRequestController@create')->name('fms.procurement.request.create');
            Route::post('/create', 'PurchaseRequestController@store')->name('fms.procurement.request.store');
            Route::get('/{id}/edit', 'PurchaseRequestController@edit')->name('fms.procurement.request.edit');
            Route::post('/{id}/edit', 'PurchaseRequestController@update')->name('fms.procurement.request.update');
            Route::get('/{id}/print', 'PurchaseRequestController@print')->name('fms.procurement.request.print');
        });

        Route::prefix('order')->group(function(){
            Route::get('/{id}/create', 'PurchaseOrderController@create')->name('fms.procurement.order.create');
            Route::post('/{id}/store', 'PurchaseOrderController@create')->name('fms.procurement.order.store');
        });

    });

    Route::prefix('obligation-request')->namespace('Forms\OBR')->group(function(){
        Route::get('/', 'ObligationRequestController@index')->name('fms.obr.index');
        Route::post('/lists', 'ObligationRequestController@lists')->name('fms.obr.lists');
        Route::get('/create', 'ObligationRequestController@create')->name('fms.obr.create');
        Route::post('/create', 'ObligationRequestController@store')->name('fms.obr.store');
        Route::get('/{id}/show', 'ObligationRequestController@show')->name('fms.obr.show');
        Route::get('/{id}/edit', 'ObligationRequestController@edit')->name('fms.obr.edit');
        Route::post('/{id}/edit', 'ObligationRequestController@update')->name('fms.obr.update');
        Route::get('/{id}/print', 'ObligationRequestController@print')->name('fms.obr.print');

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
            Route::get('/{id}/print', 'TravelOrderController@print')->name('fms.travel.order.print');

        });

    });


    

});