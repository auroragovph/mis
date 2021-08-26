<?php

use App\Http\Controllers\DevController;
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

Route::get('/', function () {
    return redirect(route('dashboard'));
});

Route::group(['middleware' => 'auth'], function(){
    Route::view('dashboard', 'dashboard')->name('dashboard');
    Route::view('home', 'home')->name('home');
});



Route::get('dev', DevController::class);

