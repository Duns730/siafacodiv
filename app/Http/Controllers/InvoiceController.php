<?php

namespace App\Http\Controllers;

use App\Invoice;
use App\InvoiceProducts;
use App\Configuration;
use Illuminate\Http\Request;
use Luecano\NumeroALetras\NumeroALetras;

class InvoiceController extends Controller
{

    public function show($id)
    {
        $invoice = Invoice::where('id', $id)->with('invoiceProducts', 'negotiationInvoices.negotiation', 'seller')->firstOrFail();
        //dd($invoice);
        return view('invoices.show', compact('invoice'));
    }

    public function annul($id)
    {
        $invoice = Invoice::where('id', $id)->firstOrFail();
        $invoice->status = 'ANULADA';
        if ($invoice->save()) {
            return redirect()->route('invoices.show', $invoice->id)->with('info', 'Proforma Anulada correctamente');
        }
        else{
            return redirect()->route('invoices.index')->with('info', 'Error, intente de nuevo');
        }
    }

    public function print($id)
    {
        $invoice = Invoice::where('id', $id)->with('negotiationInvoices.negotiation.client')->firstOrFail();
        $products = Invoice::join('invoice_products', 'invoices.id','=','invoice_products.invoice_id')
            ->join('products', 'invoice_products.product_id','=','products.id')
            ->select('invoice_products.*')
            ->where('invoices.id', $id)
            ->get();

        return \PDF::loadView('invoices.partials.print', compact('invoice', 'products'))
                    ->setPaper('letter') //, 'landscape'
                    ->stream('(FACT ' . $invoice->invoice_number . ') ' . $invoice->negotiationInvoices->negotiation->client->name . '.pdf');
    }

    public function ConvertFiscal(Request $request, Invoice $invoice)
    {
        $request->validate([    
            'invoice_number' => 'required|unique:invoices|integer|min:32000;max:99999   ',
            'date' => 'required',
            'control_number' => 'required|size:6',
            'factor' => 'numeric',
        ]);

        $invoice->invoice_number = $request->invoice_number;
        $invoice->date = $request->date;
        $invoice->control_number = $request->control_number;
        $invoice->provisional = false;

        if ($request->factor > 0) {
            $invoice->factor = $request->factor;
             $invoice->tax_base_bolivar = 0;
             $invoice_products = InvoiceProducts::where('invoice_id',  $invoice->id)->get();
             foreach ($invoice_products as $key => $product) {
                $product->unit_price_bolivar = $product->unit_price_dollar * $request->factor;
                $product->total_price_bolivar = $product->total_price_dollar * $request->factor;
                $product->save();
                $invoice->tax_base_bolivar += $product->total_price_bolivar;
             }

             $invoice->iva_bolivar = number_format($invoice->tax_base_bolivar * 0.16, 2, '.', '') ;
             $invoice->total_operation_bolivar =number_format(($invoice->tax_base_bolivar + $invoice->iva_bolivar), 2, '.', '') ;
            //dd($invoice);
        } 

        if ($invoice->save()) {

            return redirect()->route('invoices.show',$invoice->id)->with('info', 'Proforma Facturada actualizada correctamente');
        }
        else{
            return redirect()->route('invoices.show',$invoice->id)->with('info', 'Error, intente de nuevo');
        }
    }
    public function printProvisional($id)
    {
        $configuration = Configuration::find([1])->all();
        $configurations = array_combine(array_column($configuration, 'key'), array_column($configuration, 'value'));

        $invoice = Invoice::where('id', $id)->with('client', 'seller')->firstOrFail();
        $products = Invoice::join('invoice_products', 'invoices.id','=','invoice_products.invoice_id')
            ->join('products', 'invoice_products.product_id','=','products.id')
            ->select('invoice_products.*')
            ->where('invoices.id', $id)
            ->get();
            $id = str_pad(strval($invoice->client->id), 12, "jk", STR_PAD_RIGHT);


        $formatter = new NumeroALetras();
        $formatter->apocope = true;
        $formatter->conector = '';

        $invoice->amount_in_letters = $formatter->toInvoice($invoice->total_operation_bolivar, 2);
        //return view('invoices.partials.printProvisional', compact('invoice', 'products'));
        return \PDF::loadView('invoices.partials.printProvisional', compact('invoice', 'products', 'configurations'))
            ->setPaper('letter') //, 'landscape'
            ->stream('(FACT ' . $invoice->invoice_number . ') ' . $invoice->client->name . '(Provisional).pdf');
    }

    public function search_number($invoice_number)
    {
        $invoice = Invoice::where('invoice_number', $invoice_number)->with('invoiceProducts', 'negotiationInvoices.negotiation', 'seller')->firstOrFail();
        return view('invoices.show', compact('invoice'));
    }
}
