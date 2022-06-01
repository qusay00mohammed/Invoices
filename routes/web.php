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
  return view('auth.login');
});





Auth::routes(['verify' => true]);

// Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('invoices', 'InvoiceController');


Route::get('paid_invoices', 'InvoiceController@paid_invoices')->name('paid_invoices');

Route::get('unpaid_invoices', 'InvoiceController@unpaid_invoices')->name('unpaid_invoices');

Route::get('partPaid_invoices', 'InvoiceController@partPaid_invoices')->name('partPaid_invoices');

Route::get('archive_invoices', 'InvoiceController@archive_invoices')->name('archive_invoices');

Route::post('restore_invoice', 'InvoiceController@restore_invoice')->name('restore_invoice');

Route::get('print_invoice/{id}', 'InvoiceController@print_invoice')->name('print_invoice');

Route::POST('status_update/{id}', 'InvoiceController@status_update')->name('status_update');

Route::get('export_invoice_excel', 'InvoiceController@export')->name('export_invoice_excel');



Route::resource('section', 'SectionController');

Route::resource('products', 'ProductController');

Route::get('sections/{id}', 'InvoiceController@getProducts')->name('get_product');


Route::get('invoiceDetails/{id}', 'InvoiceDetailsController@edit')->name('invoiceDetails');


Route::get('view_file/{invoice_number}/{file_name}', 'InvoiceAttachmentController@show')->name('view_file');

Route::get('download_file/{invoice_number}/{file_name}', 'InvoiceAttachmentController@download')->name('download_file');


Route::post('addFile', 'InvoiceAttachmentController@store')->name('addFile');


Route::post('delete_file', 'InvoiceAttachmentController@destroy')->name('delete_file');

// Route user
Route::resource('users', 'UserController');

// End route user



// Route Permissions And Roles
Route::middleware('auth')->group(function () {
  Route::get('roles/{id}/delete', 'RoleController@destroy')->name('roles.delete');
  Route::resource('roles', 'RoleController');

  Route::get('permission/{id}/delete', 'PermissionController@destroy')->name('permissions.delete');
  Route::resource('permissions', 'PermissionController');

  Route::patch('roles/{id}/permissions', 'RolePermissionController@update')->name('roles.permissions.update');
  Route::get('permissions/{id}/role', 'RolePermissionController@index')->name('roles.permissions.index');

  // Route::resource('roles.permissions', 'RolePermissionController');
});
// End Route Permissions and Roles


Route::get('invoices_report', 'InvoiceReportController@index')->name('invoices_report');
Route::post('search_invoices', 'InvoiceReportController@search_invoices')->name('search_invoices');


Route::get('customer_report', 'CustomerReportController@index')->name('customers_report');
Route::post('search_customers', 'CustomerReportController@search_customers')->name('search_customers');


// Send email
Route::get('send-mail', 'SendEmailController@index')->name('send-mail');


Route::get('/{page}', 'AdminController@index');
