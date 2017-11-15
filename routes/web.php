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

Route::get('/', function () {
    return view('index');
});

Auth::routes();

// Routes for active clients
Route::group(['prefix' => 'app', 'middleware' => 'active.user'], function(){

	// Route for root active user directory
	Route::get('/', 'App\ActiveUserController@index')->name('app.index');

});

// Routes for admins and gods
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function(){

	// Route for root active user directory
	Route::get('/', 'Admin\AdminUserController@index')->name('admin.index');

});