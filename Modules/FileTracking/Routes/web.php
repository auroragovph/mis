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

Route::group(['prefix' => 'file-tracking', 'middleware' => 'auth:web'], function() {

    Route::get('/dashboard', 'DashboardController@index')->name('fts.dashboard');

    Route::prefix('documents')->namespace('Document')->group(function(){

        Route::get('/', 'DocumentController@index')->name('fts.documents.index');
        Route::get('/receipt', 'DocumentController@receipt')->name('fts.documents.receipt');
        Route::get('/track', 'DocumentController@track')->name('fts.documents.track');
        Route::get('/full', 'DocumentController@full')->name('fts.documents.full');

        Route::group(['prefix' => 'attachments'], function(){
            Route::get('/', 'AttachmentController@index')->name('fts.documents.attach.index');
            Route::post('/', 'AttachmentController@check')->name('fts.documents.attach.check');
            Route::get('/{id}/attachments', 'AttachmentController@form')->name('fts.documents.attach.form');
            Route::post('/{id}/attachments', 'AttachmentController@store')->name('fts.documents.attach.attach');

            Route::get('/{file}/stream', 'AttachmentController@file')->name('fts.documents.attach.file');



        });

        Route::group(['prefix' => 'receive-release', 'middleware' => ['permission:fts.sa.rr']], function(){
            Route::get('/', 'RRController@index')->name('fts.documents.rr.index');
            Route::post('/', 'RRController@form')->name('fts.documents.rr.form');
            Route::put('/', 'RRController@submit')->name('fts.documents.rr.submit');
        });

 
        // Route::get('/{id}/redirect', 'DocumentController@redirect')->name('fts.documents.redirect');
        // Route::get('/{id}/cancel', 'DocumentController@cancel')->name('fts.documents.cancel');
        // Route::post('/{id}/cancel', 'DocumentController@cancel2')->name('fts.documents.cancel2');

        Route::group(['prefix' => 'numbering'], function(){
            Route::get('/', 'NumberingController@index')->name('fts.documents.number.index');
            Route::put('/', 'NumberingController@search')->name('fts.documents.number.search');
            Route::post('/', 'NumberingController@number')->name('fts.documents.number.number');
        });

        Route::group(['prefix' => 'transmittal', 'middleware' => ['permission:fts.sa.transmittal']], function(){

            Route::get('/', 'TransmittalController@index')->name('fts.documents.transmittal.index');
            Route::post('/form', 'TransmittalController@form')->name('fts.documents.transmittal.form');

            Route::post('/form/release', 'TransmittalController@release')->name('fts.documents.transmittal.form.release');
            
            Route::get('/{uuid}/print', 'TransmittalController@print')->name('fts.documents.transmittal.print');

            Route::post('/form/receive', 'TransmittalController@form2')->name('fts.documents.transmittal.receive.form');
            Route::put('/form/receive', 'TransmittalController@receive')->name('fts.documents.transmittal.receive.submit');






        });

    });

    Route::middleware(['permission:fts.document.view'])->group(function(){

        Route::prefix('application-for-leave')->namespace('Forms')->group(function(){
            Route::get('/', 'AFLController@index')->name('fts.afl.index');
            Route::get('/create', 'AFLController@create')->name('fts.afl.create');
            Route::post('/create', 'AFLController@store')->name('fts.afl.store');
            Route::get('/{id}/edit', 'AFLController@edit')->name('fts.afl.edit');
            Route::post('/{id}/edit', 'AFLController@update')->name('fts.afl.update');
        });
    
        Route::prefix('cafoa')->namespace('Forms')->group(function(){
            Route::get('/', 'CafoaController@index')->name('fts.cafoa.index');
            Route::get('/create', 'CafoaController@create')->name('fts.cafoa.create');
            Route::post('/create', 'CafoaController@store')->name('fts.cafoa.store');
            Route::get('/{id}/edit', 'CafoaController@edit')->name('fts.cafoa.edit');
            Route::post('/{id}/edit', 'CafoaController@update')->name('fts.cafoa.update');
        });
    
        Route::prefix('disbursement-voucher')->namespace('Forms')->group(function(){
            Route::get('/', 'DisbursementVoucherController@index')->name('fts.dv.index');
            Route::get('/create', 'DisbursementVoucherController@create')->name('fts.dv.create');
            Route::post('/create', 'DisbursementVoucherController@store')->name('fts.dv.store');
            Route::get('/{id}/edit', 'DisbursementVoucherController@edit')->name('fts.dv.edit');
            Route::post('/{id}/edit', 'DisbursementVoucherController@update')->name('fts.dv.update');
        });
    
        Route::prefix('payroll')->namespace('Forms')->group(function(){
            Route::get('/', 'PayrollController@index')->name('fts.payroll.index');
            Route::get('/create', 'PayrollController@create')->name('fts.payroll.create');
            Route::post('/create', 'PayrollController@store')->name('fts.payroll.store');
            Route::get('/{id}/edit', 'PayrollController@edit')->name('fts.payroll.edit');
            Route::post('/{id}/edit', 'PayrollController@update')->name('fts.payroll.update');
        });
    
        Route::prefix('purchase-request')->namespace('Forms')->group(function(){
            Route::get('/', 'PRController@index')->name('fts.pr.index');
            Route::get('/create', 'PRController@create')->name('fts.pr.create');
            Route::post('/', 'PRController@store')->name('fts.pr.store');
            Route::get('/{id}/edit', 'PRController@edit')->name('fts.pr.edit');
            Route::post('/{id}/edit', 'PRController@update')->name('fts.pr.update');
        });
    
        Route::prefix('travel')->namespace('Forms')->group(function(){
    
            Route::prefix('itinerary')->group(function(){
                Route::get('/', 'ItineraryController@index')->name('fts.travel.itinerary.index');
                Route::get('/create', 'ItineraryController@create')->name('fts.travel.itinerary.create');
                Route::post('/create', 'ItineraryController@store')->name('fts.travel.itinerary.store');
                Route::get('/{id}/edit', 'ItineraryController@edit')->name('fts.travel.itinerary.edit');
                Route::post('/{id}/edit', 'ItineraryController@update')->name('fts.travel.itinerary.update');
    

            });
    
            Route::prefix('order')->group(function(){
                Route::get('/', 'TravelOrderController@index')->name('fts.travel.order.index');
                Route::get('/create', 'TravelOrderController@create')->name('fts.travel.order.create');
                Route::post('/create', 'TravelOrderController@store')->name('fts.travel.order.store');
                Route::get('/{id}/edit', 'TravelOrderController@edit')->name('fts.travel.order.edit');
                Route::post('/{id}/edit', 'TravelOrderController@update')->name('fts.travel.order.update');
    
            });
    
        });

    });

    Route::prefix('qr')->group(function(){
        Route::get('/', 'QRController@index')->name('fts.qr.index');
        Route::post('/generate', 'QRController@generate')->name('fts.qr.generate');
        Route::post('/print', 'QRController@print')->name('fts.qr.print');
    });

    
    
});


Route::get('file-tracking/kiosk', 'Document\KioskController@kiosk')->name('fts.documents.kiosk');
