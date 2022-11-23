<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Client;
use App\Invoice;
use App\Proforma;
use App\Product;
use App\PaymentIva;
use App\PaymentTaxBase;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function setDate()//genera las fechas de inicio y fin de mes
    {
        $base = Carbon::now();
        $sub_day_star = Carbon::now()->format('d');
        settype($sub_day_star, 'integer');
        return [
                'star' => Carbon::create($base->year, $base->month, $base->day-$sub_day_star+1, 0, 0, 0),
                'end' => Carbon::create($base->year, $base->month+1, $base->day-$sub_day_star, 23, 59, 59),
                ];
    }
    
    public function sales()
    {
        $date = $this->setDate();  
        return view('reports.sales', compact('date'));
    }

    public function salesByClients()
    {
        $date = $this->setDate();     
        return view('reports.salesByClients', compact('date'));
    }

    public function chargesByDate()
    {
        $date = $this->setDate();     
        return view('reports.chargesByDate', compact('date'));
    }

    public function clientsCollectionCommissionByDate()
    {
        $date = $this->setDate();     
        return view('reports.clientsCollectionCommissionByDate', compact('date'));
    }


    public function salesByList()
    {
        $date = $this->setDate();     
        return view('reports.salesByList', compact('date'));
    }

    public function pendingIvas()
    {
        $clients = Client::selectRaw('clients.id, clients.name, ((100 - clients.withholding_tax)/100) as withholding_tax')
                    ->join('invoices', 'invoices.client_id', '=', 'clients.id')
                    //->where('invoices.provisional', false)
                    ->where('invoices.status', '!=', 'ANULADA')
                    ->orderBy('clients.id', 'asc')
                    ->get()
                    ->unique('id');

         foreach ($clients as $key => $client) {
            $clients[$key]->pendingIva = 0;
            $invoices = Invoice::where('client_id', $client->id)
                        //->where('provisional', false)
                        ->where('status', '!=', 'ANULADA')
                        ->select('id', 'iva_bolivar')
                        ->get();
            foreach ($invoices as $keyI => $invoice) {
                $clients[$key]->pendingIva += $invoice->iva_bolivar;
                $payment_ivas = PaymentIva::where('invoice_id', $invoice->id)
                                ->selectRaw('(amount_paid/((100 - withholding_tax)/100)) AS amount_paid')
                                ->get();
                foreach ($payment_ivas as $keyPI => $payment_iva) {
                    $clients[$key]->pendingIva -= $payment_iva->amount_paid;
                }
            }
            $clients[$key]->pendingIva *= $clients[$key]->withholding_tax;

            if ($clients[$key]->pendingIva == 0) {
                unset($clients[$key]);
            }
        }
        return view('reports.pendingIvas', compact('clients'));

    }

    public function accountsReceivable()
    {
        $clients_fiscal = Client::selectRaw('clients.id, clients.name')
                    ->join('invoices', 'invoices.client_id', '=', 'clients.id')
                    ->where('invoices.provisional', false)
                    ->where('invoices.status', 'Pendiente')
                    ->get()
                    ->unique('id');
        $clients_fiscal = $this->accountsReceivableAmount($clients_fiscal, false);

        $clients_provisional = Client::selectRaw('clients.id, clients.name')
                    ->join('invoices', 'invoices.client_id', '=', 'clients.id')
                    ->where('invoices.provisional', true)
                    ->where('invoices.status', 'Pendiente')
                    ->get()
                    ->unique('id');
        $clients_provisional = $this->accountsReceivableAmount($clients_provisional, true);
        
        return view('reports.accountsReceivable', compact('clients_fiscal', 'clients_provisional'));
    }

    public function accountsReceivableAmount($clients, $provisional)
    {  
        foreach ($clients as $key => $client) {
            $clients[$key]->accountsReceivable = 0;
            $invoices = Invoice::where('client_id', $client->id)
                        ->where('provisional', $provisional)
                        ->where('status', 'Pendiente')
                        ->select('id', 'tax_base_dollar')
                        ->get();
            foreach ($invoices as $keyI => $invoice) {
                $clients[$key]->accountsReceivable += $invoice->tax_base_dollar;
                $payment_tax_bases = PaymentTaxBase::where('invoice_id', $invoice->id)
                                ->selectRaw('SUM(amount_paid) AS amount_paid')
                                ->get();
                //dd($payment_tax_bases[0]->amount_paid);
                //foreach ($payment_tax_bases as $keyPI => $payment_tax_base) {
                    $clients[$key]->accountsReceivable -= $payment_tax_bases[0]->amount_paid;
                //}
            }
            //$clients[$key]->accountsReceivable *= $clients[$key]->withholding_tax;

            if ($clients[$key]->accountsReceivable == 0) {
                unset($clients[$key]);
            }
        }
        return $clients;
    }

    public function percentageOfPaymentMethod()
    {
        $date = $this->setDate();     
        return view('reports.percentageOfPaymentMethod', compact('date'));
    }

    public function negotiationsWaste()
    {
        $date = $this->setDate();     
        return view('reports.negotiationsWaste', compact('date'));
    }

    public function negotiationsCreditTime()
    {
        $date = $this->setDate();     
        return view('reports.negotiationsCreditTime', compact('date'));
    }
}
