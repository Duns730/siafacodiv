<?php

namespace App\Http\Controllers;

use App\Negotiation;
use App\NegotiationProformas;
use App\NegotiationInvoices;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class NegotiationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->updateIvaPaymentDate();
        //$this->updateTaxBasePaymentDate();
        $negotiations = Negotiation::orderBy('created_at', 'DESC')->with('client')->paginate(50);
        return view('negotiations.index', compact('negotiations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('negotiations.create');
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
            'title' => 'required',
            'client_id' => 'required|integer',
            'days_interval' => 'required|integer',
            'payment_installments' => 'required|integer',
            'effective_percentage' => 'required|integer',
            'transfer_percentage' => 'required|integer',
            'details' => 'required',
        ]);

        $negotiation = new Negotiation;
        $negotiation->title = strtoupper(e($request->title));
        $negotiation->client_id = $request->client_id;
        $negotiation->user_id = Auth::id();
        $negotiation->days_interval = $request->days_interval;
        $negotiation->payment_installments = $request->payment_installments;
        $negotiation->effective_percentage = $request->effective_percentage;
        $negotiation->transfer_percentage = $request->transfer_percentage;
        $negotiation->details = strtoupper(e($request->details));

        if ($negotiation->save()) {
            return redirect()->route('negotiations.show', $negotiation->id)->with('info', 'Negociación creada correctamente');
        }
        else{
            return redirect()->route('negotiations.index')->with('info', 'Error, intente de nuevo');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Negotiation  $negotiation
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $negotiation = Negotiation::where('id', $id)->with('user', 'client')->firstOrFail();
        $negotiation_proformas = NegotiationProformas::where('negotiation_id', $negotiation->id)->with('proforma')->get();
        $negotiation_invoices = NegotiationInvoices::join('invoices', 'negotiation_invoices.invoice_id','=','invoices.id')->where('negotiation_id', $negotiation->id)->orderBy('invoices.invoice_number', 'ASC')->get();

        $proformas_products = NegotiationProformas::where('negotiation_id', $negotiation->id)
                    ->join('proformas', 'proformas.id', '=', 'negotiation_proformas.proforma_id')
                    ->join('proforma_products', 'proforma_products.proforma_id', '=', 'proformas.id')
                    ->join('products', 'products.id', '=', 'proforma_products.product_id')
                    ->selectRaw('proforma_products.quantity, proforma_products.total_price_dollar, reference, description, list, brand, proformas.id as proforma_id')
                    ->orderBy('products.description', 'asc')
                    ->get();
        $invoices_products = NegotiationInvoices::where('negotiation_id', $negotiation->id)
                    ->join('invoices', 'invoices.id', '=', 'negotiation_invoices.invoice_id')
                    ->join('invoice_products', 'invoice_products.invoice_id', '=', 'invoices.id')
                    ->join('products', 'products.id', '=', 'invoice_products.product_id')
                    ->selectRaw('invoice_products.quantity, invoice_products.total_price_dollar, invoice_products.reference, invoice_products.description, list, invoice_products.brand, invoices.invoice_number')
                    ->orderBy('products.description', 'asc')
                    ->get();

        return view('negotiations.show', compact('negotiation', 'negotiation_proformas', 'negotiation_invoices', 'proformas_products', 'invoices_products'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Negotiation  $negotiation
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $negotiation = Negotiation::where('id', $id)->with('client')->firstOrFail();
        if ($negotiation->user_id == Auth::id()) {
            return view('negotiations.edit', compact('negotiation'));
        }
        else{
            abort(403);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Negotiation  $negotiation
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Negotiation $negotiation)
    {
       // dd($request);
         $request->validate([    
            'title' => 'required',
            'client_id' => 'required|integer',
            'days_interval' => 'required|integer',
            'payment_installments' => 'required|integer',
            'effective_percentage' => 'required|integer',
            'transfer_percentage' => 'required|integer',
            'details' => 'required',
        ]);

        $negotiation->title = strtoupper(e($request->title));
        $negotiation->client_id = $request->client_id;
        $negotiation->days_interval = $request->days_interval;
        $negotiation->payment_installments = $request->payment_installments;
        $negotiation->effective_percentage = $request->effective_percentage;
        $negotiation->transfer_percentage = $request->transfer_percentage;
        $negotiation->details = strtoupper(e($request->details));

        if ($negotiation->save()) {
            return redirect()->route('negotiations.show', $negotiation->id)->with('info', 'Negociación creada correctamente');
        }
        else{
            return redirect()->route('negotiations.show', $negotiation->id)->with('info', 'Error, intente de nuevo');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Negotiation  $negotiation
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $negotiation = Negotiation::where('id', $id)->with('negotiationInvoices', 'negotiationProformas')->firstOrFail();
        if (!isset($negotiation->negotiationInvoices[0]) && !isset($negotiation->negotiationProformas[0])) {
            if ($negotiation->delete()) {
              return back()->with('info', 'Borrado con exito');
            }
        }
        else{
            return back()->with('info', 'Error, no puede eliminar negociaciones con proformas asociadas');
        }
        
    }

    private function updateIvaPaymentDate()
    {
        $negotiations = Negotiation::where('iva_payment_date', null)->where('invoice_date', '!=', null)->orderBy('created_at', 'DESC')->with('client')->get();

        
        foreach ($negotiations as $negotiation) {

            $amount_invoices = NegotiationInvoices::join('invoices', 'invoices.id', '=', 'negotiation_invoices.invoice_id')
                    ->where('negotiation_invoices.negotiation_id', $negotiation->id)
                    ->selectRaw('sum(iva_bolivar) * (1 - '. $negotiation->client->withholding_tax .'/ 100) as amount')
                    ->first();
            $amount_paymentIva = NegotiationInvoices::join('invoices', 'invoices.id', '=', 'negotiation_invoices.invoice_id')
                    ->join('payment_ivas', 'payment_ivas.invoice_id', '=', 'invoices.id')
                    ->where('negotiation_invoices.negotiation_id', $negotiation->id)
                    ->selectRaw('sum(amount_paid) as amount')
                    ->first();
            if($amount_invoices->amount - $amount_paymentIva->amount <= 0 && $negotiation->client->withholding_tax != 100){
              //dd($amount_invoices->amount - $amount_paymentIva->amount);
                $last_payment_date = NegotiationInvoices::join('invoices', 'invoices.id', '=', 'negotiation_invoices.invoice_id')
                    ->join('payment_ivas', 'payment_ivas.invoice_id', '=', 'invoices.id')
                    ->join('payments', 'payments.id', '=', 'payment_ivas.payment_id')
                    ->where('negotiation_invoices.negotiation_id', $negotiation->id)
                    ->selectRaw('payments.date')
                    ->orderBy('payments.date', 'desc')
                    ->paginate(1);
              //dd($last_payment_date);

                $negotiation = Negotiation::where('id', $negotiation->id)->firstOrFail();
                $negotiation->update([
                        'iva_payment_date' => $last_payment_date[0]->date
                    ]);
            } 
        }
        
    }

    private function updateTaxBasePaymentDate()
    {
        $negotiations = Negotiation::where('full_payment', null)->where('invoice_date', '!=', null)->orderBy('created_at', 'DESC')->get();

        foreach ($negotiations as $negotiation) {

            $amount_invoices = NegotiationInvoices::join('invoices', 'invoices.id', '=', 'negotiation_invoices.invoice_id')
                    ->where('negotiation_invoices.negotiation_id', $negotiation->id)
                    ->selectRaw('sum(tax_base_dollar) as amount')
                    ->first();

             $amount_payment_tax_base = NegotiationInvoices::join('invoices', 'invoices.id', '=', 'negotiation_invoices.invoice_id')
                    ->join('payment_tax_bases', 'payment_tax_bases.invoice_id', '=', 'invoices.id')
                    ->where('negotiation_invoices.negotiation_id', $negotiation->id)
                    ->selectRaw('sum(amount_paid) as amount')
                    ->first();

            if(($amount_invoices->amount - $amount_payment_tax_base->amount) <= 0){
                     $last_payment_date = NegotiationInvoices::join('invoices', 'invoices.id', '=', 'negotiation_invoices.invoice_id')
                        ->join('payment_tax_bases', 'payment_tax_bases.invoice_id', '=', 'invoices.id')
                        ->join('payments', 'payments.id', '=', 'payment_tax_bases.payment_id')
                        ->where('negotiation_invoices.negotiation_id', $negotiation->id)
                        ->selectRaw('payments.date')
                        ->orderBy('payments.date', 'desc')
                        ->paginate(1);

                    $negotiation = Negotiation::where('id', $negotiation->id)->firstOrFail();
                    $negotiation->update([
                        'full_payment' => $last_payment_date[0]->date
                    ]);
                }
        }
        
    }
}
