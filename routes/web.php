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

Auth::routes();

Route::get('/', function () { return view('index'); })->name('web');

// Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home', function(){
	return view('home');
})->name('home');

// Routes for admins and gods
Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function(){

 		// Route for root active user directory
		Route::get('/', 'Admin\AdminController@index')->name('admin.index');
});

// Routes for active clients
Route::group(['prefix' => 'app', 'middleware' => 'active.user'], function(){

	// Route for root active user directory
	Route::get('/', 'App\UserController@index')->name('app.index');
	Route::get('profile', 'App\UserController@profile')->name('profile');
	Route::put('profile', 'App\UserController@updateProfile')->name('profile.update');
	Route::get('settings', 'App\UserController@settings')->name('settings');
	Route::put('settings', 'App\UserController@updateSettings')->name('settings.update');

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
	Route::get('invoices/pending', 'InvoiceController@pending')->name('invoices.pending');
	Route::post('invoices', 'InvoiceController@store')->name('invoices.store');
	Route::get('invoices/create', 'InvoiceController@create')->name('invoices.create');
	Route::get('invoices/{invoice}', 'InvoiceController@show')->name('invoices.show');
	Route::get('invoices/{invoice}/edit', 'InvoiceController@edit')->name('invoices.edit');
	Route::put('invoices/{invoice}', 'InvoiceController@update')->name('invoices.update');
	Route::delete('invoices/{invoice}', 'InvoiceController@delete')->name('invoices.delete');
	Route::get('invoices/{invoice}/pdf/show', 'InvoiceController@showPDF')->name('invoices.pdf.show');
	Route::put('invoices/{invoice_id}/pay', 'InvoiceController@pay')->name('invoices.pay');
	Route::put('invoices/{invoice_id}/unpay', 'InvoiceController@unpay')->name('invoices.unpay');

	//Invoices API routes
	Route::get('invoicesapi', 'Api\InvoiceController@index')->name('api.invoices');
	Route::delete('invoicesapi/{id}', 'Api\InvoiceController@delete')->name('api.invoices.delete');
	Route::put('invoicesapi/{id}', 'Api\InvoiceController@update')->name('api.invoices.update');

	//Clinics API routes
	Route::get('clinicsapi', 'Api\ClinicController@index')->name('api.clinics');
	Route::delete('clinicsapi/{id}', 'Api\ClinicController@deactivate')->name('api.clinics.delete');

});



