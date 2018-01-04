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
    return view('welcome');
});

Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', function(){
	return view('home');
})->name('home');

Route::group(['prefix' => 'app', 'middleware' => 'auth'], function(){

	Route::get('/', 'HomeController@index')->name('index');

	//Clinics routes
	Route::get('clinics', 'ClinicController@index')->name('clinics.index');
	Route::post('clinics', 'ClinicController@store')->name('clinics.store');
	Route::get('clinics/create', 'ClinicController@create')->name('clinics.create');
	Route::get('clinics/{clinic}', 'ClinicController@show')->name('clinics.show');
	Route::get('clinics/{clinic}/edit', 'ClinicController@edit')->name('clinics.edit');
	Route::put('clinics/{clinic}', 'ClinicController@update')->name('clinics.update');
	Route::delete('clinics/{clinic}', 'ClinicController@delete')->name('clinics.delete');
	Route::put('clinics/{clinic}/deactivate', 'ClinicController@deactivate')->name('clinics.deactivate');

	//Clinic->invoices routes
	Route::get('clinics/{clinic}/invoices', 'ClinicController@invoices')->name('clinics.invoices');
	Route::post('clinics/{clinic}/invoices', 'ClinicController@storeInvoice')->name('clinics.invoices.store');
	Route::get('clinics/{clinic}/invoices/create', 'ClinicController@createInvoice')->name('clinics.invoices.create');
	Route::get('clinics/{clinic}/invoices/{invoice}', 'ClinicController@showInvoice')->name('clinics.invoices.show');
	Route::get('clinics/{clinic}/invoices/{invoice}/edit', 'ClinicController@editInvoice')->name('clinics.invoices.edit');
	Route::put('clinics/{clinic}/invoices/{invoice}', 'ClinicController@updateInvoice')->name('clinics.invoices.update');
	Route::delete('clinics/{clinic}/invoices/{invoice}', 'ClinicController@deleteInvoice')->name('clinics.invoices.delete');

	//Invoices routes
	Route::get('invoices', 'InvoiceController@index')->name('invoices.index');
	Route::post('invoices', 'InvoiceController@store')->name('invoices.store');
	Route::get('invoices/create', 'InvoiceController@create')->name('invoices.create');
	Route::get('invoices/{invoice}', 'InvoiceController@show')->name('invoices.show');
	Route::get('invoices/{invoice}/edit', 'InvoiceController@edit')->name('invoices.edit');
	Route::put('invoices/{invoice}', 'InvoiceController@update')->name('invoices.update');
	Route::delete('invoices/{invoice}', 'InvoiceController@delete')->name('invoices.delete');
	Route::get('invoices/{invoice}/pdf/show', 'InvoiceController@showPDF')->name('invoices.pdf.show');

});
