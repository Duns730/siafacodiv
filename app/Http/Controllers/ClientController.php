<?php

namespace App\Http\Controllers;

use App\Client;
use App\Seller;
use App\Address;
use App\Negotiation;
use App\Proforma;
use App\Invoice;
use App\PaymentTaxBase;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function __construct()
    {
       // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::orderBy('id', 'ASC')->with('seller')->paginate(100);
        $total_clients = Client::selectRaw('count(*) as count')->first();
        return view('clients.index', compact('clients', 'total_clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sellers = Seller::orderBy('id', 'ASC')->pluck('name', 'id');
        return view('clients.create', compact('sellers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([    
            'name' => 'required',
            'rif' => 'required',
            'phones' => 'required|max:40',
            'email' => 'required|email',
            'withholding_tax' => 'required|integer',
            'seller_id' => 'required|integer',
            'fiscal_address' => 'required',
            'state_id' => 'required|integer',
            'municipality_id' => 'required|integer',
            'population_center_id' => 'required|integer',
            'location_id' => 'required|integer',
        ]);

        $client = new Client;
        $client->name = strtoupper($request->name);
        $client->rif = strtoupper(e($request->rif));
        $client->phones = e($request->phones);
        $client->email = strtoupper(e($request->email));
        $client->withholding_tax = e($request->withholding_tax);
        $client->seller_id = $request->seller_id;
        $client->fiscal_address = strtoupper(e($request->fiscal_address));

        $address = $request->all();

        if ($client->save()) {
            $client->address()->create($address);
            return redirect()->route('clients.show', $client->id)->with('info', 'Cliente creado correctamente');
        }
        else{
            return redirect()->route('clients.index')->with('info', 'Error, intente de nuevo');
        }      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::where('id', $id)->with('seller', 'address.state', 'address.municipality', 'address.populationCenter', 'address.location')->firstOrFail();
        $negotiations = $this->ShowNegotiations($id);
        $payments = $this->ShowPayments($id);

        
        return view('clients.show', compact('client', 'negotiations', 'payments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::where('id', $id)->with('address.state', 'address.municipality', 'address.populationCenter', 'address.location')->firstOrFail();
        $sellers = Seller::orderBy('id', 'ASC')->pluck('name', 'id');
        return view('clients.edit', compact('client','sellers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $request->validate([    
            'name' => 'required',
            'rif' => 'required',
            'phones' => 'required|max:40',
            'email' => 'required|email',
            'withholding_tax' => 'required|integer',
            'seller_id' => 'required|integer',
            'fiscal_address' => 'required',
        ]);

        if (isset($request->municipality_id) || isset($request->state_id)) {
            $request->validate([    
                'state_id' => 'required|integer',
                'municipality_id' => 'required|integer',
                'population_center_id' => 'required|integer',
                'location_id' => 'required|integer',
            ]);
            $address = $request->all();
        }
        
        $client->name = strtoupper($request->name);
        $client->rif = strtoupper(e($request->rif));
        $client->phones = e($request->phones);
        $client->email = strtoupper(e($request->email));
        $client->withholding_tax = e($request->withholding_tax);
        $client->seller_id = $request->seller_id;
        $client->fiscal_address = strtoupper(e($request->fiscal_address));

        if ($client->save()) {
            if (isset($address)) {
                $client->address()->create($address);
                Address::where('id', $client->address->id)->delete();
            }
            return redirect()->route('clients.show', $client->id)->with('info', 'Cliente actualizado correctamente');
        }
        else{
            return redirect()->route('clients.index')->with('info', 'Error, intente de nuevo');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         if (Client::findOrFail($id)->delete()) {
              return back()->with('info', 'Borrado con exito');
          } 
        else{
            return back()->with('info', 'Error, intente de nuevo');
        }
    }

    public function ShowNegotiations($id) //genera las negociaciones que seran mostradas en la vista del cliente
    {
        $negotiations = Negotiation::where('client_id', $id)->with('negotiationProformas', 'negotiationInvoices')->orderBy('created_at', 'DESC')->get();
        foreach ($negotiations as $key =>  $negotiation) {
            if (!empty($negotiation->invoice_date)) {
                foreach ($negotiation->negotiationInvoices as $negotiationInvoice){
                   $amount =  Invoice::where('id', $negotiationInvoice->invoice_id)
                            ->where('status', '!=', 'ANULADA')
                            ->selectRaw('SUM(tax_base_dollar) as tax_base_dollar')
                            ->first();
                       $negotiations[$key]->total_proformed +=  $amount->tax_base_dollar;
                }
            }
            else{
                foreach ($negotiation->negotiationProformas as $negotiationProforma){
                   $amount =  Proforma::where('id', $negotiationProforma->proforma_id)->select('tax_base_dollar')->first();
                    $negotiations[$key]->total_proformed +=  $amount->tax_base_dollar;
                }
            }
            
        }
        return $negotiations;
    }

    public function ShowPayments($id)
    {
        $payments = Invoice::where('client_id', $id)
                    ->join('payment_tax_bases', 'payment_tax_bases.invoice_id', '=', 'invoices.id')
                    ->join('payments', 'payments.id', '=', 'payment_tax_bases.payment_id')
                    ->selectRaw('payments.id, payments.concept, payments.amount, payments.collection_commission')
                    ->orderBy('payments.date', 'ASC')
                    ->get()
                    ->unique('id');
        foreach ($payments as $key => $payment) {
            $paid = PaymentTaxBase::where('payment_id', $payment->id)->selectRaw('SUM(amount_paid) AS amount_paid')->first();
            $payments[$key]->amount_paid = $paid->amount_paid;
        }
        return $payments;
    }
}
