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


// Route::get('dev', function(){
//     dd(boolval('0'));
// });


// Authentication module
Route::prefix('auth')->group(function(){
    Route::get('/signin', 'Auth\SignInController@form')->name('login');
    Route::post('/signin', 'Auth\SignInController@authenticate');
    Route::post('/signout', 'Auth\SignInController@logout');
});


Route::group(['prefix' => 'system', 'middleware' => ['auth:web', 'permission:sys.sudo']], function(){

    Route::get('/', function(){
        return redirect(route('sys.dashboard'));
    });

    Route::get('/dashboard', 'DashboardController@index')->name('sys.dashboard');


    Route::prefix('office')->namespace('Office')->group(function(){

        Route::get('/', 'OfficeController@index')->name('sys.office.index');
        Route::post('/', 'OfficeController@store')->name('sys.office.store');

        Route::prefix('division')->group(function(){
            Route::get('/', 'DivisionController@index')->name('sys.office.division.index');
            Route::post('/', 'DivisionController@store')->name('sys.office.division.store');
        });

    });


    Route::prefix('user')->namespace('User')->group(function(){

        Route::get('/', 'UserController@index')->name('sys.user.index');
        Route::post('/', 'UserController@store')->name('sys.user.store');


        Route::prefix('acl')->namespace('ACL')->group(function(){

            Route::get('/', 'ACLController@index')->name('sys.user.acl.index');
            Route::post('/store', 'PermissionController@store')->name('sys.user.acl.perm.store');


            Route::get('/{id}/user', 'ACLController@show')->name('sys.user.acl.show');
            Route::post('/{id}/user', 'ACLController@store')->name('sys.user.acl.store');

        });

    });

});
