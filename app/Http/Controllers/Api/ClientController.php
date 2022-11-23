<?php

namespace App\Http\Controllers\Api;

use App\Client;
use App\Negotiation;
use App\Proforma;
use App\Invoice;
use App\NegotiationInvoices;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(
            Client::orderBy('id', 'ASC')->select('id', 'name', 'rif')->get()
            );
    }

    public function getNegotations($id)//id del cliente
    {
        return response()->json(
            Client::where('id', $id)->with('negotiations')->select('id')->orderBy('created_at', 'ASC')->get() 
            );
    }

    public function orderGraph($id)
    {
        $client = Client::rightJoin('negotiations', 'clients.id', '=', 'negotiations.client_id')
                ->where('clients.id', $id)
                ->select('negotiations.*')
                ->orderBy('negotiations.invoice_date', 'ASC')
                ->get();

        $labels = [];
        $data = [];
        foreach ($client as $negotiation) {
            $amount = 0;
            if (!empty($negotiation->invoice_date)) {
                array_push($labels, date('d/m/Y', strtotime($negotiation->invoice_date)));
                $negotiation_invoices = NegotiationInvoices::where('negotiation_id', $negotiation->id)->get();

                foreach ($negotiation_invoices as $negotiation_invoice){
                   $invoice =  Invoice::where('id', $negotiation_invoice->invoice_id)
                            ->where('status', '!=', 'ANULADA')
                            ->selectRaw('SUM(tax_base_dollar) as tax_base_dollar')
                            ->first();
                   $amount += $invoice->tax_base_dollar;
                }
                array_push($data, $amount);
            }
        }
        return response()->json([
                'status' => 201,
                'labels' => $labels,
                'data' => $data,
            ]);
    }

    public function purchaseProformas($id)
    {
        return response()->json([
            'clients_proformas' => 
                Client::join('client_purchase_proformas', 'client_purchase_proformas.client_id', '=', 'clients.id')
                ->where('client_purchase_proformas.purchase_id', $id)
                ->select('clients.id', 'clients.name')
                ->orderBy('client_purchase_proformas.created_at', 'ASC')
                ->get()
                ->unique('id'),
            'clients_invoices' => 
                Client::join('invoices', 'invoices.client_id', '=', 'clients.id')
                ->join('client_purchase_invoices', 'client_purchase_invoices.invoice_id', '=', 'invoices.id')
                ->where('client_purchase_invoices.purchase_id', $id)
                ->select('clients.id', 'clients.name')
                ->orderBy('client_purchase_invoices.created_at', 'ASC')
                ->get()
                ->unique('id'),
            'products_proformas' =>  
                Client::join('client_purchase_proformas', 'client_purchase_proformas.client_id', '=', 'clients.id')
                   ->join('proformas', 'client_purchase_proformas.proforma_id', '=', 'proformas.id')
                   ->join('proforma_products', 'proforma_products.proforma_id', '=', 'proformas.id')
                   ->where('client_purchase_proformas.purchase_id', $id)
                   ->select('clients.id as client', 
                        'proforma_products.product_id',
                        'proforma_products.proforma_id',
                        'proforma_products.quantity')
                    ->get(),
            'products_invoices' =>  
                Client::join('invoices', 'invoices.client_id', '=', 'clients.id')
                    ->join('client_purchase_invoices', 'client_purchase_invoices.invoice_id', '=', 'invoices.id')
                    ->join('invoice_products', 'invoice_products.invoice_id', '=', 'invoices.id')
                    ->where('client_purchase_invoices.purchase_id', $id)
                    ->select('clients.id as client', 
                            'invoice_products.product_id',
                            'invoice_products.quantity')
                    ->get()
       ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paymentIva($id, $provisional)
    {
        $client_invoices = Client::where('clients.id', $id)
            ->where('invoices.provisional', boolval($provisional))
            ->where('invoices.status', 'PENDIENTE')
            ->join('invoices', 'invoices.client_id', '=', 'clients.id')
            ->select('invoices.id', 'invoices.invoice_number', 'invoices.date', 'invoices.factor',
                    'invoices.iva_dollar','invoices.iva_bolivar','invoices.status', 'clients.withholding_tax'
                    )
            ->orderBy('invoices.invoice_number', 'DESC')//ASC
            ->get();

        foreach ($client_invoices as $key => $invoice) {
            $client_invoices[$key]->to_pay_bolivar = $invoice->iva_bolivar * (1 - $invoice->withholding_tax / 100);
            $client_invoices[$key]->to_pay_dollar = $invoice->iva_dollar * (1 - $invoice->withholding_tax / 100);
            $paymentsIva = Invoice::where('invoice_number', $invoice->invoice_number)->with('paymentIva')->first();
            if (count($paymentsIva->paymentIva) > 0) {
                foreach ($paymentsIva->paymentIva as $payment) {
                    $client_invoices[$key]->to_pay_bolivar -= $payment->amount_paid;
                    $client_invoices[$key]->to_pay_dollar -= $payment->amount_paid/$invoice->factor;
                }
                if ($client_invoices[$key]->to_pay_bolivar < 1) {
                    unset($client_invoices[$key]);
                }
            }
        }
        return response()->json($client_invoices);
    }

    public function paymentTaxBase($id, $provisional)
    {
        $client_invoices = Client::where('clients.id', $id)
            ->where('invoices.provisional', boolval($provisional))
            ->where('invoices.status', 'PENDIENTE')
            ->join('invoices', 'invoices.client_id', '=', 'clients.id')
            ->select('invoices.id', 'invoices.invoice_number', 'invoices.date', 'invoices.factor',
                    'invoices.tax_base_dollar','invoices.tax_base_bolivar','invoices.status',
                    )
            ->orderBy('invoices.invoice_number', 'DESC')//ASC
            ->get();

        foreach ($client_invoices as $key => $invoice) {
            //$client_invoices[$key]->to_pay_dollar = $invoice->tax_base_dollar;
            $payments_tax_base = Invoice::where('invoice_number', $invoice->invoice_number)->with('paymentTaxBase')->first();
            if (count($payments_tax_base->paymentTaxBase) > 0) {
                foreach ($payments_tax_base->paymentTaxBase as $payment) {
                    $client_invoices[$key]->tax_base_dollar -= $payment->amount_paid;
                }
                if ($client_invoices[$key]->tax_base_dollar < 0) {
                    unset($client_invoices[$key]);
                }
            }
        }
          
        return response()->json($client_invoices);
    }

}
