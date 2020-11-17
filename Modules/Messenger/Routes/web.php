<?php

use Illuminate\Support\Facades\Route;



Route::prefix('messenger')->group(function() {

    Route::get('/', 'MessengerController@index')->name('messenger.home');
    Route::get('/{id}/messages', 'MessengerController@messages')->name('messenger.messages');
    Route::post('/{id}/messages', 'MessengerController@send')->name('messenger.send');

});
