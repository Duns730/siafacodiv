<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonImmutable;
use App\Client;
use App\Invoice;
use App\Proforma;
use App\Product;
use App\Negotiation;
use App\NegotiationInvoices;
use App\PaymentTaxBase;


class ReportController extends Controller
{
    public function setDate()//genera las fechas de inicio y fin de mes
    {
        $base = Carbon::now();
        $sub_day_star = Carbon::now()->format('d');
        settype($sub_day_star, 'integer');
        return [
                //'star' => Carbon::now()->subDay($sub_day_star-1),
                'star' => Carbon::create($base->year, $base->month, $base->day-$sub_day_star+1, 0, 0, 0),
                //'end' => Carbon::now()->addMonth()->subDay($sub_day_star),
                'end' => Carbon::create($base->year, $base->month+1, $base->day-$sub_day_star, 23, 59, 59),
                ];
    }

    public function sales(Request $request)
    {
        return response()->json(
            Invoice::orderBy('invoice_number', 'ASC')
                ->with('client')
                ->where('date', '>=', $request->data['star'])
                ->where('date', '<=', $request->data['end'])
                ->where('provisional', $request->data['provisional'])
                ->get()
            );
    }

    public function salesDown($star, $end, $provisional)
    {
        $invoices = Invoice::orderBy('invoice_number', 'ASC')
                ->with('client')
                ->where('date', '>=', $star)
                ->where('date', '<=', $end)
                ->where('provisional', $provisional)
                ->get();
        if ($provisional == 1) {
            $provisional = 'Provisional ';
            $invoices->provisional = '(Provisional)';
        }
        else{
            $provisional = '';
            $invoices->provisional = '';
        }
        $date = [
                'now' => Carbon::now()->format('d-m-Y'),
                'star' => date('d-m-Y ', strtotime($star)),
                'end' => date('d-m-Y ', strtotime($end)),
                ];  
                
         $pdf = \PDF::loadView('reports.pdf.sales', compact('invoices', 'date'))
            ->setPaper('letter'); //, 'landscape'
            
          return  $pdf->stream('Reporte de Ventas ' . $provisional . '(' . $date['star'] . ' al ' . $date['end'] . ').pdf');
    }


    public function invoicedDays()
    {
        $date = $this->setDate();
        $labels = [];
        $data = [];
        $day = $date['star'];

        $invoices = Invoice::orderBy('updated_at', 'ASC')
                ->where('updated_at', '>=', $date['star']->format('Y-m-d'))
                ->where('updated_at', '<=', $date['end']->format('Y-m-d'))
                ->where('provisional', false)
                ->select('updated_at', 'tax_base_dollar')
                ->get();
        while (
            $day->format('Y-m-d') >= $date['star']->format('Y-m-d') 
            && $day->format('Y-m-d') <= $date['end']->format('Y-m-d')
            ){

            array_push($labels, $day->format('d/m/Y'));
            $amount = 0;
            foreach ($invoices as $key => $invoice) {
                if ($invoice->updated_at->format('Y-m-d') == $day->format('Y-m-d')) {
                    $amount += $invoice->tax_base_dollar;
                    unset($invoices[$key]);
                }
                 
            }
            array_push($data, $amount);
            $day = $date['star']->addDay(1);
        } 

        return response()->json([
                'status' => 201,
                'labels' => $labels,
                'data' => $data,
                'title' => 'Monto Total: '. number_format(array_sum($data), 2, ',', '.'),
            ]);

    }

    public function proformedDays()
    {
        $date = $this->setDate();

        $labels = [];
        $data = [];
        $day = $date['star'];

        $proformas = Proforma::orderBy('created_at', 'ASC')
                ->where('created_at', '>=', $date['star']->format('Y-m-d'))
                ->where('created_at', '<=', $date['end']->format('Y-m-d'))
                ->select('created_at', 'tax_base_dollar')
                ->get();
        while (
            $day->format('Y-m-d') >= $date['star']->format('Y-m-d') 
            && $day->format('Y-m-d') <= $date['end']->format('Y-m-d')
            ){

            array_push($labels, $day->format('d/m/Y'));
            $amount = 0;
            foreach ($proformas as $key => $proforma) {
                if ($proforma->created_at->format('Y-m-d') == $day->format('Y-m-d')) {
                    $amount += $proforma->tax_base_dollar;
                    unset($proformas[$key]);
                }
            }
            array_push($data, $amount);
            $day = $date['star']->addDay(1);
        } 

        return response()->json([
                'status' => 201,
                'labels' => $labels,
                'data' => $data,
                'title' => 'Monto Total: '. number_format(array_sum($data), 2, ',', '.'),
            ]);
    }

    public function statusProformedMonth()
    {
        $date = $this->setDate();

        $labels = [];
        $data = [];
        $day = $date['star'];
        $cont = 1;

        $negotiations = Negotiation::orderBy('created_at', 'ASC')
                ->with('negotiationProformas.proforma')
                ->where('proformed_date', '>=', $date['star']->format('Y-m-d'))
                ->where('invoice_date', '<=', $date['end']->format('Y-m-d'))
                ->get();
                dd($negotiations);
    }

    public function salesByClients(Request $request)
    {
        $clients = Invoice::selectRaw('clients.name, clients.id, sellers.name as seller, states.name as state')
            ->join('clients', 'clients.id', '=', 'invoices.client_id')
            ->join('sellers', 'sellers.id', '=', 'clients.seller_id')
            ->join('addresses', 'addresses.addressable_id', '=', 'clients.id')
            ->join('states', 'states.id', '=', 'addresses.state_id')
            ->where('addresses.addressable_type', 'App\Client')
            ->where('invoices.date', '>=', $request->data['star'])
            ->where('invoices.date', '<=', $request->data['end'])
            ->where('invoices.provisional', $request->data['provisional'])
            ->orderBy('clients.id', 'asc')
            ->get()
            ->unique('id');
        foreach ($clients as $key => $client) {
            $clients[$key]->total_amount = Invoice::where('client_id', $client->id)
                ->where('date', '>=', $request->data['star'])
                ->where('date', '<=', $request->data['end'])
                ->where('provisional', $request->data['provisional'])
                ->where('status', '!=', 'ANULADA')
                ->selectRaw('SUM(tax_base_dollar) as total_amount')
                ->get();
        }
        return response()->json($clients);
    }

    public function salesByClientsDown($star, $end, $provisional)
    {
        $clients = Invoice::selectRaw('clients.name, clients.id, sellers.name as seller, states.name as state')
            ->join('clients', 'clients.id', '=', 'invoices.client_id')
            ->join('sellers', 'sellers.id', '=', 'clients.seller_id')
            ->join('addresses', 'addresses.addressable_id', '=', 'clients.id')
            ->join('states', 'states.id', '=', 'addresses.state_id')
            ->where('addresses.addressable_type', 'App\Client')
            ->where('invoices.date', '>=', $star)
            ->where('invoices.date', '<=', $end)
            ->where('invoices.provisional', $provisional)
            ->orderBy('clients.id', 'asc')
            ->get()
            ->unique('id');
        foreach ($clients as $key => $client) {
            $clients[$key]->total_amount = Invoice::where('client_id', $client->id)
                ->where('date', '>=', $star)
                ->where('date', '<=', $end)
                ->where('provisional', $provisional)
                ->where('status', '!=', 'ANULADA')
                ->selectRaw('SUM(tax_base_dollar) as total_amount')
                ->get();
        }

        if ($provisional == 1) {
            $provisional = 'Provisional ';
            $clients->provisional = '(Provisional)';
        }
        else{
            $provisional = '';
            $clients->provisional = '';
        }
        $date = [
                'now' => Carbon::now()->format('d-m-Y'),
                'star' => date('d-m-Y ', strtotime($star)),
                'end' => date('d-m-Y ', strtotime($end)),
                ];  
                
         $pdf = \PDF::loadView('reports.pdf.salesByClients', compact('clients', 'date'))
            ->setPaper('letter'); //, 'landscape'
            
          return  $pdf->stream('Reporte de Ventas por Clientes ' . $provisional . '(' . $date['star'] . ' al ' . $date['end'] . ').pdf');
    }

    public function salesByList(Request $request)
    {
        $lists = Product::orderBy('list', 'asc')->select('list')->get()->unique('list');
        $total_amount = 0;
        foreach ($lists as $key => $list) {
            $lists[$key]->products = Product::selectRaw('SUM(invoice_products.total_price_dollar) as amout')
                        ->join('invoice_products', 'invoice_products.product_id', '=', 'products.id')
                        ->join('invoices', 'invoices.id', '=', 'invoice_products.invoice_id')
                        ->where('invoices.date', '>=', $request->data['star'])
                        ->where('invoices.date', '<=', $request->data['end'])
                        ->where('invoices.provisional', $request->data['provisional'])
                        ->where('invoices.status', '!=', 'ANULADA')
                        ->where('products.list', $list->list)
                        ->get();
            $total_amount += $lists[$key]->products[0]->amout;
        }
        return response()->json($lists);
    }

    public function chargesByDate(Request $request)
    {
        $clients = Invoice::selectRaw('clients.name, clients.id')
            ->join('clients', 'clients.id', '=', 'invoices.client_id')
            ->join('payment_tax_bases', 'payment_tax_bases.invoice_id', '=', 'invoices.id')
            ->join('payments', 'payment_tax_bases.payment_id', '=', 'payments.id')
            ->where('payments.date', '>=', $request->data['star'])
            ->where('payments.date', '<=', $request->data['end'])
            ->where('invoices.provisional', $request->data['provisional'])
            //->where('invoices.status', '!=', 'ANULADA')
            ->orderBy('clients.id', 'asc')
            ->get()
            ->unique('id');

        
        foreach ($clients as $key => $client) {
            $amount_payments = 0;
            $amount_paid = 0;
            $collection_commission = 0;
            $payments = Invoice::selectRaw('payments.id,  payments.amount, payments.collection_commission')
                        ->join('payment_tax_bases', 'payment_tax_bases.invoice_id', '=', 'invoices.id')
                        ->join('payments', 'payment_tax_bases.payment_id', '=', 'payments.id')
                        ->where('payments.date', '>=', $request->data['star'])
                        ->where('payments.date', '<=', $request->data['end'])
                        ->where('invoices.provisional', $request->data['provisional'])
                        ->where('payments.type', '!=', 'nota de credito')
                        ->where('invoices.client_id', $client->id)
                        ->get()
                        ->unique('id');
                
            foreach ($payments as $keyP => $payment) {
                $amount_payments += $payment->amount;
                $collection_commission += $payment->collection_commission;
                $paid = PaymentTaxBase::where('payment_id', $payment->id)->selectRaw('SUM(amount_paid) AS amount_paid')->first();
                
                $amount_paid += $paid->amount_paid;
            }
            $clients[$key]->amount_paid = $amount_paid;
            $clients[$key]->amount_payments = $amount_payments;
            $clients[$key]->collection_commission = $collection_commission;
        }
        return response()->json($clients);
    }

    public function clientsCollectionCommissionByDate(Request $request)
    {
        $clients = Invoice::selectRaw('clients.name, clients.id, payments.date, payments.collection_commission, payments.id as payments_id')
            ->join('clients', 'clients.id', '=', 'invoices.client_id')
            ->join('payment_tax_bases', 'payment_tax_bases.invoice_id', '=', 'invoices.id')
            ->join('payments', 'payment_tax_bases.payment_id', '=', 'payments.id')
            ->where('payments.date', '>=', $request->data['star'])
            ->where('payments.date', '<=', $request->data['end'])
            ->where('payments.collection_commission', '>', 0)
            ->where('invoices.provisional', $request->data['provisional'])
            //->where('invoices.status', '!=', 'ANULADA')
            ->orderBy('payments.date', 'asc')
            ->get()
            ->unique('payments_id');
        return response()->json($clients);
    }

    public function percentageOfPaymentMethod(Request $request)
    {
        $negotiations = Negotiation::select('id', 'client_id', 'title', 'transfer_percentage', 'effective_percentage')
                        ->where('created_at', '>=', $request->data['star'])
                        ->where('created_at', '<=', $request->data['end'])
                        ->get();
        foreach ($negotiations as $key => $negotiation) {
           $negotiations[$key]->client = Client::where('id', $negotiation->client_id)->select('name')->first();
           $total_amount_proformas = Proforma::selectRaw('SUM(tax_base_dollar) as tax_base_dollar')
                    ->join('negotiation_proformas', 'negotiation_proformas.proforma_id', '=', 'proformas.id')
                    ->where('negotiation_proformas.negotiation_id', $negotiation->id)
                    ->first();
            $total_amount_invoices = Invoice::selectRaw('SUM(tax_base_dollar) as tax_base_dollar')
                    ->join('negotiation_invoices', 'negotiation_invoices.invoice_id', '=', 'invoices.id')
                    ->where('negotiation_invoices.negotiation_id', $negotiation->id)
                    ->first();
  
            $negotiations[$key]->total_amount = $total_amount_proformas->tax_base_dollar + $total_amount_invoices->tax_base_dollar;
        }
        return response()->json($negotiations);
    }

    public function negotiationsWaste(Request $request)
    {
        $negotiations = Negotiation::selectRaw('negotiations.id, client_id, title, starting_amount, clients.name')
                        ->join('clients', 'clients.id', '=', 'negotiations.client_id')
                        ->where('invoice_date', '!=', null)
                        ->where('negotiations.created_at', '>=', $request->data['star'])
                        ->where('negotiations.created_at', '<=', $request->data['end'])
                        ->orderBy('negotiations.created_at', 'desc')
                        ->get();

        foreach ($negotiations as $key => $negotiation) {
            $invoiced = NegotiationInvoices::selectRaw('SUM(invoices.tax_base_dollar) as amount')
                    ->join('invoices', 'invoices.id', '=', 'negotiation_invoices.invoice_id')
                    ->where('negotiation_id', $negotiation->id)
                    ->first();
            $negotiations[$key]->invoiced =  $invoiced->amount;
            if ($negotiations[$key]->starting_amount - $invoiced->amount > 0) {
                $negotiations[$key]->waste = $negotiations[$key]->starting_amount - $invoiced->amount;
            }
            else{
                $negotiations[$key]->waste = 0;
            }
         } 
        return response()->json($negotiations);
    }

    public function negotiationsCreditTime(Request $request)
    {
         $negotiations = Negotiation::selectRaw('negotiations. id, client_id, title, days_interval, payment_installments, deliver_date, clients.name' )
                        ->join('clients', 'clients.id', '=', 'negotiations.client_id')
                        ->where('deliver_date', '!=', null)
                        ->where('negotiations.created_at', '>=', $request->data['star'])
                        ->where('negotiations.created_at', '<=', $request->data['end'])
                        ->orderBy('negotiations.deliver_date', 'desc')
                        ->get();

        foreach ($negotiations as $key => $negotiation) {
            if ($negotiation->days_interval == 0) {
                $negotiations[$key]->days_interval = 1;
            }
            $negotiations[$key]->credit_time = $negotiations[$key]->days_interval * $negotiations[$key]->payment_installments;

            $negotiations[$key]->now = Carbon::now()->diffInDays(Carbon::create($negotiation->deliver_date));

            $negotiations[$key]->progress_percentage = number_format(($negotiations[$key]->now * 100) / $negotiations[$key]->credit_time, 2);


            $negotiations[$key]->payment_date = Carbon::create($negotiation->deliver_date)->addDays($negotiations[$key]->days_interval * $negotiations[$key]->payment_installments);


            $negotiations[$key]->payment_date = date('d/m/Y', strtotime($negotiation->payment_date));
            $negotiations[$key]->deliver_date = date('d/m/Y', strtotime($negotiation->deliver_date));
        }

        return response()->json($negotiations);
    }
}
