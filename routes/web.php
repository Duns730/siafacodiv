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
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');


Route::middleware(['auth'])->group(function(){
	Route::get('/', 'DashboardController@dashboard')->name('dashboard');


//Route users
	Route::get('users', 'UserController@index')->name('users.index')->middleware('permission:users.index');
	Route::get('users/create', 'UserController@create')->name('users.create')->middleware('permission:users.create');
	Route::post('users', 'UserController@store')->name('users.store')->middleware('permission:users.create');
	//Route::get('users/{user}', 'UserController@show')->name('users.show')->middleware('permission:users.show');
	Route::get('users/{user}/edit', 'UserController@edit')->name('users.edit')->middleware('permission:users.edit');
	Route::put('users/{user}', 'UserController@update')->name('users.update')->middleware('permission:users.edit');
	Route::delete('users/{user}', 'UserController@destroy')->name('users.destroy')->middleware('permission:users.destroy');

//Route sellers
	Route::get('sellers', 'SellerController@index')->name('sellers.index')->middleware('permission:sellers.index');
	Route::get('sellers/create', 'SellerController@create')->name('sellers.create')->middleware('permission:sellers.create');
	Route::post('sellers', 'SellerController@store')->name('sellers.store')->middleware('permission:sellers.create');
	Route::get('sellers/{seller}', 'SellerController@show')->name('sellers.show')->middleware('permission:sellers.show');
	Route::get('sellers/{seller}/edit', 'SellerController@edit')->name('sellers.edit')->middleware('permission:sellers.edit');
	Route::put('sellers/{seller}', 'SellerController@update')->name('sellers.update')->middleware('permission:sellers.edit');
	Route::delete('sellers/{seller}', 'SellerController@destroy')->name('sellers.destroy')->middleware('permission:sellers.destroy');

//Route clients
	Route::get('clients', 'ClientController@index')->name('clients.index')->middleware('permission:clients.index');
	Route::get('clients/create', 'ClientController@create')->name('clients.create')->middleware('permission:clients.create');
	Route::post('clients', 'ClientController@store')->name('clients.store')->middleware('permission:clients.create');
	Route::get('clients/{client}', 'ClientController@show')->name('clients.show')->middleware('permission:clients.show');
	Route::get('clients/{client}/edit', 'ClientController@edit')->name('clients.edit')->middleware('permission:clients.edit');
	Route::put('clients/{client}', 'ClientController@update')->name('clients.update')->middleware('permission:clients.edit');
	Route::delete('clients/{client}', 'ClientController@destroy')->name('clients.destroy')->middleware('permission:clients.destroy');

//Route negotiations
	Route::get('negotiations', 'NegotiationController@index')->name('negotiations.index')->middleware('permission:negotiations.index');
	Route::get('negotiations/create', 'NegotiationController@create')->name('negotiations.create')->middleware('permission:negotiations.create');
	Route::post('negotiations', 'NegotiationController@store')->name('negotiations.store')->middleware('permission:negotiations.create');
	Route::get('negotiations/{negotiation}', 'NegotiationController@show')->name('negotiations.show')->middleware('permission:negotiations.show');
	Route::get('negotiations/{negotiation}/edit', 'NegotiationController@edit')->name('negotiations.edit')->middleware('permission:negotiations.edit');
	Route::put('negotiations/{negotiation}', 'NegotiationController@update')->name('negotiations.update')->middleware('permission:negotiations.edit');
	Route::delete('negotiations/{negotiation}', 'NegotiationController@destroy')->name('negotiations.destroy')->middleware('permission:negotiations.destroy');

//Route products
	Route::get('products', 'ProductController@index')->name('products.index')->middleware('permission:products.index');
	Route::get('products/create', 'ProductController@create')->name('products.create')->middleware('permission:products.create');
	Route::post('products', 'ProductController@store')->name('products.store')->middleware('permission:products.create');
	Route::get('products/{product}', 'ProductController@show')->name('products.show')->middleware('permission:products.show');
	Route::get('products/{product}/edit', 'ProductController@edit')->name('products.edit')->middleware('permission:products.edit');
	Route::put('products/{product}', 'ProductController@update')->name('products.update')->middleware('permission:products.edit');
	Route::delete('products/{product}', 'ProductController@destroy')->name('products.destroy')->middleware('permission:products.destroy');
	Route::get('products/massive/load', 'ProductController@massiveLoad')->name('products.massiveload')		->middleware('permission:products.massiveload');
	Route::get('products/massive/update', 'ProductController@massiveUpdate')->name('products.massiveupdate')		->middleware('permission:products.massiveupdate');

//Route proformas
	Route::get('proformas', 'ProformaController@index')->name('proformas.index')->middleware('permission:proformas.index');
	Route::get('proformas/create', 'ProformaController@create')->name('proformas.create')->middleware('permission:proformas.create');
	Route::post('proformas', 'ProformaController@store')->name('proformas.store')->middleware('permission:proformas.create');
	Route::get('proformas/{proforma}', 'ProformaController@show')->name('proformas.show')->middleware('permission:proformas.show');
	Route::get('proformas/{proforma}/edit', 'ProformaController@edit')->name('proformas.edit')->middleware('permission:proformas.edit');
	Route::get('proformas/{proforma}/debug', 'ProformaController@debug')->name('proformas.debug')->middleware('permission:proformas.debug');
	Route::get('proformas/{proforma}/print', 'ProformaController@print')->name('proformas.print')->middleware('permission:proformas.print');
	Route::get('proformas/{proforma}/invoicing', 'ProformaController@invoicing')->name('proformas.invoicing')->middleware('permission:proformas.invoicing');
	Route::put('proformas/{proforma}', 'ProformaController@update')->name('proformas.update')->middleware('permission:proformas.edit');
	Route::delete('proformas/{product}', 'ProformaController@destroy')->name('proformas.destroy')->middleware('permission:proformas.destroy');
	Route::get('proformas/create/provisional', 'ProformaController@createProvisional')->name('proformas.create.provisional')->middleware('permission:proformas.create.provisional');
	Route::get('proformas/{proforma}/edit/provisional', 'ProformaController@editProvisional')->name('proformas.edit.provisional')->middleware('permission:proformas.edit');
	Route::get('proformas/{proforma}/debug/provisional', 'ProformaController@debugProvisional')->name('proformas.debug.provisional')->middleware('permission:proformas.debug');
	Route::get('proformas/{proforma}/invoicing/provisional', 'ProformaController@invoicingProvisional')->name('proformas.invoicing.provisional')->middleware('permission:proformas.invoicing');

//Route invoices
	Route::get('invoices/{invoice}', 'InvoiceController@show')->name('invoices.show');
	Route::get('invoices/search/{invoice_number}', 'InvoiceController@search_number')->name('invoices.search.number');
	Route::get('invoices/annul/{invoice}', 'InvoiceController@annul')->name('invoices.annul')->middleware('permission:proformas.invoices.annul');
	Route::get('invoices/{invoice}/print', 'InvoiceController@print')->name('invoices.print');
	Route::get('invoices/{invoice}/print/provisional', 'InvoiceController@printProvisional')->name('invoices.print.provisional');
	Route::post('invoices/{invoice}/convertfiscal', 'InvoiceController@ConvertFiscal')->name('invoices.convertfiscal')->middleware('permission:proformas.provisional.convert.fiscal');

//Route reports
	Route::get('reports/sales', 'ReportController@sales')->name('reports.sales');
	Route::get('reports/sales/byclients', 'ReportController@salesByClients')->name('reports.sales.byclients');
	Route::get('reports/sales/bylist', 'ReportController@salesByList')->name('reports.sales.bylist');
	Route::get('reports/pending/ivas', 'ReportController@pendingIvas')->name('reports.pending.ivas');
	Route::get('reports/accounts/receivable', 'ReportController@accountsReceivable')->name('reports.accounts.receivable');
	Route::get('reports/charges/bydate', 'ReportController@chargesByDate')->name('reports.charges.bydate');
	Route::get('reports/clients/collection/commission', 'ReportController@clientsCollectionCommissionByDate')->name('reports.clients.collection.commission');
	Route::get('reports/negotiations/percentage/payment/method', 'ReportController@percentageOfPaymentMethod')->name('reports.negotiations.percentage.payment.method');
	Route::get('reports/negotiations/waste', 'ReportController@negotiationsWaste')->name('reports.negotiations.waste');
	Route::get('reports/negotiations/credit/time', 'ReportController@negotiationsCreditTime')->name('reports.negotiations.credit.time');

//Route purchases
	Route::get('purchases', 'PurchaseController@index')->name('purchases.index')->middleware('permission:purchases.index');
	Route::get('purchases/create', 'PurchaseController@create')->name('purchases.create')->middleware('permission:purchases.create');
	Route::post('purchases', 'PurchaseController@store')->name('purchases.store')->middleware('permission:purchases.create');
	Route::get('purchases/{purchase}', 'PurchaseController@show')->name('purchases.show')->middleware('permission:purchases.show');
	Route::get('purchases/{purchase}/edit', 'PurchaseController@edit')->name('purchases.edit')->middleware('permission:purchases.edit');
	Route::put('purchases/{purchase}', 'PurchaseController@update')->name('purchases.update')->middleware('permission:purchases.edit');
	Route::delete('purchases/{purchase}', 'PurchaseController@destroy')->name('purchases.destroy')->middleware('permission:purchases.destroy');
	Route::get('purchases/load/{purchase}', 'PurchaseController@load')->name('purchases.load')->middleware('permission:purchases.load');
	Route::get('purchases/load/{purchase}/edit', 'PurchaseController@loadEdit')->name('purchases.load.edit')->middleware('permission:purchases.load.edit');
	Route::get('purchases/{purchase}/massive/load', 'PurchaseController@massiveLoad')->name('purchases.massiveload')->middleware('permission:purchases.massiveload');

//Route controlquantity
	Route::get('controlquantity', 'ClientPurchaseProformaController@show')->name('controlquantity')->middleware('permission:products.controlquantity');


//Route banks
	Route::get('banks', 'BankController@index')->name('banks.index')->middleware('permission:banks.index');
	Route::get('banks/create', 'BankController@create')->name('banks.create')->middleware('permission:banks.create');
	Route::post('banks', 'BankController@store')->name('banks.store')->middleware('permission:banks.create');
	Route::get('banks/{bank}', 'BankController@show')->name('banks.show')->middleware('permission:banks.show');
	Route::get('banks/{bank}/edit', 'BankController@edit')->name('banks.edit')->middleware('permission:banks.edit');
	Route::put('banks/{bank}', 'BankController@update')->name('banks.update')->middleware('permission:banks.edit');
	Route::delete('banks/{bank}', 'BankController@destroy')->name('banks.destroy')->middleware('permission:banks.destroy');

//Route payments
	Route::get('payments', 'PaymentController@index')->name('payments.index')->middleware('permission:payments.index');
	Route::get('payments/process/iva', 'PaymentController@processIva')->name('payments.process.iva')->middleware('permission:payments.process');
	Route::get('payments/process/taxbase', 'PaymentController@processTaxBase')->name('payments.process.taxbase')->middleware('permission:payments.process');
	Route::post('payments/process/', 'PaymentController@store')->name('payments.store')->middleware('permission:payments.process');
	Route::get('payments/show/{payment}/iva', 'PaymentController@showIva')->name('payments.show.iva')->middleware('permission:payments.show.iva');
	Route::get('payments/show/{payment}/taxbase', 'PaymentController@showTaxBase')->name('payments.show.taxbase')->middleware('permission:payments.show.taxbase');
	Route::get('payments/show/{payment}/invoice', 'PaymentController@showInvoice')->name('payments.show.invoice')->middleware('permission:payments.show.invoice');


//Route Download resource
	Route::get('download/products/massiveload', function () {
    	return Storage::download("public/formato_para_carga_masiva_de_productos.csv");
	})->name('download.products.massiveload');
	Route::get('download/instructions/utf8', function () {
    	return Storage::download("public/Instrucciones_utf8.docx");
	})->name('download.instructions.utf8');
	Route::get('download/purchase/massiveload', function () {
    	return Storage::download("public/Formato_para_cargar_cantidades_en_compra.csv");
	})->name('download.purchase.massiveload');

//Route Configurations
	Route::get('configurations', 'ConfigurationController@index')->name('configurations.index')->middleware('permission:configurations.index');


//Route Transport
	Route::get('creditnotes', 'creditNoteController@index')->name('creditnotes.index')->middleware('permission:creditnotes.index');
	Route::get('creditnotes/create', 'creditNoteController@create')->name('creditnotes.create')->middleware('permission:creditnotes.create');
	Route::get('creditnotes/{creditnote}', 'creditNoteController@show')->name('creditnotes.show')->middleware('permission:creditnotes.show');
	Route::get('creditnotes/{creditnote}/print/dollar', 'creditNoteController@printDollar')->name('creditnotes.print.dollar');
	Route::get('creditnotes/{creditnote}/print/bolivar', 'creditNoteController@printBolivar')->name('creditnotes.print.bolivar');

//Route Transport
	Route::get('transports', 'TransportController@index')->name('transports.index')->middleware('permission:transports.index');
	Route::get('transports/create', 'TransportController@create')->name('transports.create')->middleware('permission:transports.create');
	Route::post('transports', 'TransportController@store')->name('transports.store')->middleware('permission:transports.create');
	Route::get('transports/{transport}', 'TransportController@show')->name('transports.show')->middleware('permission:transports.show');
	Route::get('transports/{transport}/edit', 'TransportController@edit')->name('transports.edit')->middleware('permission:transports.edit');
	Route::put('transports/{transport}', 'TransportController@update')->name('transports.update')->middleware('permission:transports.edit');
	Route::delete('transports/{transport}', 'TransportController@destroy')->name('transports.destroy')->middleware('permission:transports.destroy');



	//Route::resource('users', 'UserController')->names('users');
});









/*
Route::resource('admin/doctors', 'DoctorController')->names('doctors');
Route::get('admin/consultingrooms/create/{doctor_id}', 'ConsultingRoomController@create')->name('consultingrooms.create');
Route::resource('admin/consultingrooms', 'ConsultingRoomController')->names('consultingrooms')->except(['create', 'index']);

*/






