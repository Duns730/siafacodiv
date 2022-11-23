<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('adresses/states', 'Api\AdressController@states');
Route::get('adresses/municipalities/{state_id}', 'Api\AdressController@municipalities');
Route::get('adresses/population-centers/{municipality_id}', 'Api\AdressController@populationCenters');
Route::get('adresses/locations/{populationcenter_id}', 'Api\AdressController@locations');

Route::post('adresses/population-centers/store', 'Api\AdressController@storePopulationCenter');
Route::post('adresses/locations/store', 'Api\AdressController@storeLocations');


Route::get('permission/', 'Api\PermissionController@index');
Route::get('permission/{user}/user', 'Api\PermissionController@indexUser');
Route::post('permission/store', 'Api\PermissionController@store');
Route::post('permission/destroy', 'Api\PermissionController@destroy');

Route::get('clients/', 'Api\ClientController@index');
Route::get('clients/{client}/negotiations', 'Api\ClientController@getNegotations');
Route::get('clients/ordergraph/{client}', 'Api\ClientController@orderGraph');
Route::get('clients/purchase/{client}/proformas/', 'Api\ClientController@purchaseProformas');
Route::get('clients/{client}/payment/iva/{provisional}', 'Api\ClientController@paymentIva');
Route::get('clients/{client}/payment/taxbase/{provisional}', 'Api\ClientController@paymentTaxBase');

Route::get('image/destroy/{id}', 'Api\ImageController@destroy');

Route::get('prices/{id}/product', 'Api\PriceController@show');
Route::post('prices/update', 'Api\PriceController@update');


Route::post('products/list/price', 'Api\ProductController@byListPrice');
Route::get('products/', 'Api\ProductController@index');
Route::post('products/massive/load', 'Api\ProductController@massiveLoad');
Route::post('products/massive/load/store', 'Api\ProductController@massiveLoadStore');
Route::post('products/massive/update', 'Api\ProductController@massiveUpdate');
Route::post('products/massive/update/store', 'Api\ProductController@massiveUpdateStore');

Route::post('proformas/store', 'Api\ProformaController@store');
Route::post('proformas/products', 'Api\ProformaController@ListProducts');
Route::post('proformas/update/edit', 'Api\ProformaController@updateEdit');
Route::post('proformas/update/debug', 'Api\ProformaController@updateDebug');
Route::post('proformas/store/provisional', 'Api\ProformaController@storeProvisional');
Route::post('proformas/update/edit/provisional', 'Api\ProformaController@updateEditProvisional');
Route::post('proformas/update/debug/provisional', 'Api\ProformaController@updateDebugProvisional');


Route::get('negotiations/proformasgraph/{id}', 'Api\NegotiationController@proformasGraph');
Route::get('negotiations/invoicesgraph/{id}', 'Api\NegotiationController@invoicesGraph');
Route::post('negotiations/selectionwarehouse', 'Api\NegotiationController@selectionWarehouseActive');
Route::post('negotiations/warehousepacking', 'Api\NegotiationController@warehousePackingActive');
Route::post('negotiations/warehousepacked', 'Api\NegotiationController@warehousePackedActive');
Route::post('negotiations/orderdelivered', 'Api\NegotiationController@orderDelivered');
Route::get('negotiations/client/{fragment}', 'Api\NegotiationController@listByClient');

Route::post('invoices/create', 'Api\InvoiceController@store');
Route::post('invoices/products', 'Api\InvoiceController@products');

Route::get('sellers/', 'Api\SellerController@index');


Route::post('reports/sales', 'Api\ReportController@sales');
Route::get('reports/sales/down/{star}/{end}/{provisional}', 'Api\ReportController@salesDown');
Route::get('reports/invoiced/month/days', 'Api\ReportController@invoicedDays');
Route::get('reports/proformed/month/days', 'Api\ReportController@proformedDays');
Route::get('reports/status/proformed/month', 'Api\ReportController@statusProformedMonth');
Route::post('reports/sales/byclients', 'Api\ReportController@salesByClients');
Route::get('reports/sales/byclients/down/{star}/{end}/{provisional}', 'Api\ReportController@salesByClientsDown');
Route::post('reports/sales/bylist', 'Api\ReportController@salesByList');
Route::post('reports/charges/bydate', 'Api\ReportController@chargesByDate');
Route::post('reports/clients/collection/commission', 'Api\ReportController@clientsCollectionCommissionByDate');
Route::post('reports/negotiations/percentage/payment/method', 'Api\ReportController@percentageOfPaymentMethod');
Route::post('reports/negotiations/waste', 'Api\ReportController@negotiationsWaste');
Route::post('reports/negotiations/credit/time', 'Api\ReportController@negotiationsCreditTime');

Route::get('purchases', 'Api\PurchaseController@index');
Route::post('purchases/save', 'Api\PurchaseController@save');
Route::post('purchases/totalize', 'Api\PurchaseController@totalize');
Route::get('purchases/{id}/products', 'Api\PurchaseController@getProductsProformas');
Route::get('purchases/{id}/products/controlquantity', 'Api\PurchaseController@getProductsControlQuantity');
Route::post('purchases/massive/load', 'Api\PurchaseController@massiveLoad');
Route::post('purchases/massive/load/store', 'Api\PurchaseController@massiveLoadStore');

Route::get('banks/{currency}', 'Api\BankController@index');

Route::post('payments/process/', 'Api\PaymentController@store');

Route::post('configurations/update', 'Api\ConfigurationController@update');


Route::get('drivers/{transport_id}', 'Api\DriverController@index');
Route::post('drivers/store', 'Api\DriverController@store');

Route::post('creditnotes/create', 'Api\CreditNoteController@store');


