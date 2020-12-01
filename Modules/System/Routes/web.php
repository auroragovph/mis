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
    });

    Route::prefix('acl')->namespace('ACL')->group(function(){

        Route::prefix('permission')->group(function(){
            Route::get('/', 'PermissionController@index')->name('sys.acl.permission.index');
        });

        Route::prefix('role')->group(function(){
            Route::get('/', 'RoleController@index')->name('sys.acl.role.index');
            Route::post('/', 'RoleController@store')->name('sys.acl.role.store');
        });

    });

});


Route::group([
    'prefix' => 'special-pages',
    'middleware' => 'auth:web',
    'namespace' => 'SpecialPages'
], function(){

    Route::prefix('login')->group(function(){
        Route::get('/first-login', 'SP_LoginController@first')->name('sp.login.first');
        Route::post('/first-login', 'SP_LoginController@first')->name('sp.login.first.post');
    });

});
