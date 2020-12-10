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

Route::get('/', function () {
    return redirect(route('root.home'));
});


Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('root.home')->middleware('auth:web');



Route::group(['prefix' => 'dev', 'middleware' => ['auth:web', 'permission:godmode']], function(){
    Route::get('/', 'DevController@index');
    Route::get('/liaison', 'DevController@liaison');
});

