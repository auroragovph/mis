<?php

use Illuminate\Support\Facades\Route;
use Modules\System\core\Http\Livewire\Auth\Login;

Route::group(['middleware' => 'guest'], function(){
    Route::get('login', Login::class)->name('login');
});
