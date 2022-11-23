<?php

namespace App\Http\Controllers\Api;

use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Proforma;
use App\NegotiationProformas;
use App\Negotiation;
use App\ProformaProducts;
use App\Invoice;
use App\NegotiationInvoices;
use App\InvoiceProducts;
use App\ClientPurchaseProforma;
use App\ClientPurchaseInvoice;

class InvoiceController extends Controller
{
    public function store(Request $request)
    {
        $result = Validator::make($request->data, [
            'invoice_number' => ['required', 'unique:invoices', 'integer']
        ]);

        if ($result->fails()) {
            return response()->json([
                'status' => 406,
                'message' => 'Verifique el número de factura. Posibles errores:
                            <ul><li>Ya está registrado</li><li>Número fuera de formato</li><ul>
                                ',
            ]);
        }

        $negotiation = Negotiation::where('id', $request->data['negotiation_id'])->firstOrFail();

        if (empty($negotiation->selection_warehouse_date) || empty($negotiation->debug_date)) {
            return response()->json([
                'status' => 406,
                'message' => 'No puede Facturar esta proforma hasta que se haya enviado a Almacén(Selección) y esté depurada.',
            ]);
        }

        $invoice = new Invoice;
        $invoice->client_id = e($request->data['client_id']);
        $invoice->seller_id = e($request->data['seller_id']);
        $invoice->factor = e($request->data['factor']);
        $invoice->invoice_number = e($request->data['invoice_number']);
        $invoice->date = e($request->data['date']);
        $invoice->tax_base_dollar = e($request->data['tax_base_dollar']);
        $invoice->tax_base_bolivar = e($request->data['tax_base_bolivar']);
        $invoice->iva_dollar = e($request->data['iva_dollar']);
        $invoice->iva_bolivar = e($request->data['iva_bolivar']);
        $invoice->total_operation_dollar = $request->data['total_operation_dollar'];
        $invoice->total_operation_bolivar = e($request->data['total_operation_bolivar']);
        $invoice->provisional = $request->data['provisional'];
        if (isset($request->data['control_number'])) {
            $invoice->control_number = $request->data['control_number'];
        }

        if ($invoice->save()) {
            foreach ($request->data['products'] as $product) {
                InvoiceProducts::create([
                    'product_id' => $product['id'],
                    'invoice_id' => $invoice->id,
                    'reference' => $product['reference'],
                    'description' => $product['description'],
                    'brand' => e($product['brand']),
                    'quantity' => $product['quantity'],
                    'unit_price_dollar' => $product['price'],
                    'unit_price_bolivar' => $product['price_bolivar'],
                    'total_price_dollar' => $product['sub_total_dollar'],
                    'total_price_bolivar' => $product['sub_total_bolivar'],
                ]);
            }
            NegotiationInvoices::create([
                'negotiation_id' => $request->data['negotiation_id'],
                'invoice_id' => $invoice->id,
            ]);

            if (isset($request->data['purchase_id']) && is_numeric($request->data['purchase_id'])) {
                    ClientPurchaseProforma::where('proforma_id', $request->data['id'])->delete();
                    ClientPurchaseInvoice::create([
                        'purchase_id' => $request->data['purchase_id'],
                        'invoice_id' => $invoice->id,
                    ]);
            }
            NegotiationProformas::where('proforma_id', $request->data['id'])->delete();
            ProformaProducts::where('proforma_id', $request->data['id'])->delete();
            Proforma::findOrFail($request->data['id'])->delete();
    
            $negotiation->invoice_date = date('Y-m-d H:i:s');
            $negotiation->save(); 


            return response()->json([
                'status' => 201,
                'invoice_id' => $invoice->id,
            ]);
        
        } 
    }

    public function products(Request $request)
    {
        return response()->json(
            Invoice::join('invoice_products', 'invoice_products.invoice_id', '=', 'invoices.id')
                ->where('client_id', $request->data['client_id'])
                ->whereIn('invoice_number', $request->data['invoices'])
                ->selectRaw('invoices.factor, invoice_products.*')
                ->get()
            );

    }
}
