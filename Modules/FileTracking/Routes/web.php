<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'file-tracking', 'middleware' => 'auth:web'], function() {

    Route::get('/dashboard', 'DashboardController@index')->name('fts.dashboard');

    Route::prefix('documents')->namespace('Document')->group(function(){

        Route::get('/', 'DocumentController@index')->name('fts.documents.index');

        Route::get('/receipt', 'DocumentController@receipt')->name('fts.documents.receipt');

        Route::get('/track', 'DocumentController@track')->name('fts.documents.track');


        Route::group(['prefix' => 'attachments'], function(){
            Route::get('/', 'AttachmentController@index')->name('fts.documents.attach.index');
            Route::post('/', 'AttachmentController@check')->name('fts.documents.attach.check');
            Route::get('/{id}/attachments', 'AttachmentController@form')->name('fts.documents.attach.form');
            Route::post('/{id}/attachments', 'AttachmentController@attach')->name('fts.documents.attach.attach');
        });

        Route::group(['prefix' => 'receive-release', 'middleware' => ['permission:fts.sa.rr']], function(){
            Route::get('/', 'RRController@index')->name('fts.documents.rr.index');
            Route::post('/', 'RRController@form')->name('fts.documents.rr.form');
            Route::put('/', 'RRController@submit')->name('fts.documents.rr.submit');
        });

 
        // Route::get('/{id}/redirect', 'DocumentController@redirect')->name('fts.documents.redirect');
        // Route::get('/{id}/cancel', 'DocumentController@cancel')->name('fts.documents.cancel');
        // Route::post('/{id}/cancel', 'DocumentController@cancel2')->name('fts.documents.cancel2');

        

        // Route::group(['prefix' => 'receive-release', 'middleware' => ['permission:fms.sa.rr|sys.sudo']], function(){
        //     Route::get('/', 'RRController@index')->name('fts.documents.rr.index');
        //     Route::post('/', 'RRController@form')->name('fts.documents.rr.form');
        //     Route::put('/', 'RRController@submit')->name('fts.documents.rr.submit');
        // });



        // Route::group(['prefix' => 'attachments'], function(){
        //     Route::get('/', 'AttachmentController@index')->name('fts.documents.attach.index');
        //     Route::post('/', 'AttachmentController@check')->name('fts.documents.attach.check');
        //     Route::get('/{id}/attachments', 'AttachmentController@form')->name('fts.documents.attach.form');
        //     Route::post('/{id}/attachments', 'AttachmentController@attach')->name('fts.documents.attach.attach');
        // });


       

        // Route::group(['prefix' => 'numbering'], function(){
        //     Route::get('/', 'NumberingController@index')->name('fts.documents.number.index');
        //     Route::put('/', 'NumberingController@search')->name('fts.documents.number.search');
        //     Route::post('/', 'NumberingController@number')->name('fts.documents.number.number');
        // });


        // Route::prefix('track')->group(function(){
        //     Route::get('/', 'TrackingController@track')->name('fts.documents.track');
        // });



    });


    Route::prefix('procurement')->namespace('Forms\Procurement')->group(function(){

        Route::prefix('request')->group(function(){
            Route::get('/', 'PurchaseRequestController@index')->name('fts.procurement.request.index');
            Route::post('/', 'PurchaseRequestController@store')->name('fts.procurement.request.store');
         
        });

        // Route::prefix('order')->group(function(){
        //     Route::get('/{id}/create', 'PurchaseOrderController@create')->name('fts.procurement.order.create');
        //     Route::post('/{id}/store', 'PurchaseOrderController@create')->name('fts.procurement.order.store');
        // });

    });

    Route::prefix('qr')->group(function(){
        Route::get('/', 'QRController@index')->name('fts.qr.index');
        Route::post('/generate', 'QRController@generate')->name('fts.qr.generate');
    });

    
    
});
