<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;
use App\Proforma;
use Carbon\Carbon;

class DashboardController extends Controller
{

    public function dashboard()
    {
        $base = Carbon::now();
        $sub_day_star = Carbon::now()->format('d');
        settype($sub_day_star, 'integer');
        $date = [
                //'star' => Carbon::now()->subDay($sub_day_star-1),
                'star' => Carbon::create($base->year, $base->month, $base->day-$sub_day_star+1, 0, 0, 0),
                //'end' => Carbon::now()->addMonth()->subDay($sub_day_star),
                'end' => Carbon::create($base->year, $base->month+1, $base->day-$sub_day_star, 23, 59, 59),
                ];
    	        
        $clients_invoiced = $this->clientsInvoiced($date, false);
        $clients_proformed = $this->clientsProformed($date, false);
        $clients_invoiced_provisional = $this->clientsInvoiced($date, true);
        $clients_proformed_provisional = $this->clientsProformed($date, true);

        //dd($clients_invoiced);
        return view('dashboard', compact('clients_invoiced', 'clients_proformed', 'clients_invoiced_provisional', 'clients_proformed_provisional'));
    }

    public function clientsInvoiced($date, $provisional)
    {	
    	$total_amount_invoiced = 0;
    	$clients_invoiced = Invoice::selectRaw('LEFT(clients.name, 36) as name, clients.id')
        	->join('clients', 'clients.id', '=', 'invoices.client_id')
            ->where('invoices.date', '>=', $date['star'])
            ->where('invoices.date', '<=', $date['end'])
            ->where('invoices.provisional', $provisional)
            ->orderBy('clients.id', 'asc')
            ->get()
            ->unique('id');
        foreach ($clients_invoiced as $key => $client_invoiced) {
        	$clients_invoiced[$key]->amout_total = 0;
        	$invoice = Invoice::where('client_id', $client_invoiced->id)
	            ->where('date', '>=', $date['star'])
	            ->where('date', '<=', $date['end'])
                ->where('provisional', $provisional)
	            ->where('status', '!=', 'ANULADA')
	            ->selectRaw('SUM(tax_base_dollar) as tax_base_dollar')
	            ->first();

	        $clients_invoiced[$key]->amout_total = $invoice->tax_base_dollar;
	        $total_amount_invoiced += $invoice->tax_base_dollar;
        }
        return [
        		'clients_invoiced' => $clients_invoiced,
        		'total_amount_invoiced' => $total_amount_invoiced,
        	];
    }

    public function clientsProformed($date, $provisional)
    {
    	$total_amount_proformed = 0;
    	$clients_proformed = Proforma::selectRaw('LEFT(clients.name, 36) as name, clients.id')	
        	->join('negotiation_proformas', 'negotiation_proformas.proforma_id', '=', 'proformas.id')
        	->join('negotiations', 'negotiations.id', '=', 'negotiation_proformas.negotiation_id')
        	->join('clients', 'clients.id', '=', 'negotiations.client_id')
            ->where('proformas.created_at', '>=', $date['star'])
            ->where('proformas.created_at', '<=', $date['end'])
            ->where('proformas.provisional', $provisional)
            ->orderBy('clients.id', 'asc')
            ->get()
            ->unique('id');
            
        foreach ($clients_proformed as $key => $client_invoiced) {
        	$clients_proformed[$key]->amout_total = 0;
        	$proforma = Proforma::where('negotiations.client_id', $client_invoiced->id)
	            ->join('negotiation_proformas', 'negotiation_proformas.proforma_id', '=', 'proformas.id')
	        	->join('negotiations', 'negotiations.id', '=', 'negotiation_proformas.negotiation_id')
	            ->where('proformas.created_at', '>=', $date['star'])
	            ->where('proformas.created_at', '<=', $date['end'])
	            ->where('proformas.provisional', $provisional)
	            ->selectRaw('SUM(tax_base_dollar) as tax_base_dollar')
	            ->first();

	        	$clients_proformed[$key]->amout_total = $proforma->tax_base_dollar;
	        	$total_amount_proformed += $proforma->tax_base_dollar;
        }
        return [
        		'clients_proformed' => $clients_proformed,
        		'total_amount_proformed' => $total_amount_proformed,
        	];
    }
}
