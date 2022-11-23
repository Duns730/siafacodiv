<?php

namespace App\Http\Controllers;

use App\Proforma;
use App\ProformaProducts;
use App\Negotiation;
use App\NegotiationProformas;
use App\NegotiationInvoices;
use Illuminate\Http\Request;

class ProformaController extends Controller
{
     
    public function index()
    {
        $proformas = Proforma::with('negotiationProformas.negotiation')->orderBy('id', 'DESC')->paginate(100);
        return view('proformas.index', compact('proformas'));
    }

    
    public function create()
    {
        return view('proformas.create');
    }

    public function createProvisional()
    {
        return view('proformas.createProvisional');
    }

    
    public function show($id)
    {
        $proforma = Proforma::where('id', $id)->with('proformaProducts.product.price', 'negotiationProformas.negotiation', 'clientPurchaseProforma')->firstOrFail();
        return view('proformas.show', compact('proforma'));
    }

    
    public function edit($id)
    {   
        $proforma = Proforma::where('id', $id)->with('negotiationProformas.negotiation.client')->firstOrFail();
        return view('proformas.edit',compact('proforma'));
    }

    public function editProvisional($id)
    {   
        $proforma = Proforma::where('id', $id)->with('negotiationProformas.negotiation.client', 'clientPurchaseProforma')->firstOrFail();
        return view('proformas.editProvisional',compact('proforma'));
    }

    public function debug($id)
    {   
        $proforma = Proforma::where('id', $id)->with('negotiationProformas.negotiation.client')->firstOrFail();
        return view('proformas.debug',compact('proforma'));
    }

    public function debugProvisional($id)
    {   
        $proforma = Proforma::where('id', $id)->with('negotiationProformas.negotiation.client', 'clientPurchaseProforma')->firstOrFail();
        return view('proformas.debugProvisional',compact('proforma'));
    }

    public function invoicing($id)
    {   
        $proforma = Proforma::where('id', $id)->with('negotiationProformas.negotiation.client.seller')->firstOrFail();
        return view('proformas.invoicing',compact('proforma'));
    }

    public function invoicingProvisional($id)
    {   
        $proforma = Proforma::where('id', $id)->with('negotiationProformas.negotiation.client.seller', 'clientPurchaseProforma')->firstOrFail();
        return view('proformas.invoicingProvisional',compact('proforma'));
    }

    
    public function print($id)
    {
        $proforma = Proforma::where('id', $id)->with('negotiationProformas.negotiation.client')->firstOrFail();

        $products = Proforma::join('proforma_products', 'proformas.id','=','proforma_products.proforma_id')
            ->join('products', 'proforma_products.product_id','=','products.id')
            ->join('prices', 'prices.product_id','=','products.id')
            ->select('proforma_products.*', 'products.*', 'prices.'. $proforma->type_price. ' as price' )
            ->where('proformas.id', $id)
            ->get();

        return \PDF::loadView('proformas.partials.print', compact('proforma', 'products'))
            ->setPaper('letter') //, 'landscape'
            ->stream('Proforma ' . $proforma->negotiationProformas->negotiation->client->name . ' #' . $id . '.pdf');
    }

    
    public function destroy($id)
    {
        $proforma = Proforma::where('id', $id)->with('negotiationProformas')->firstOrFail();
        $negotiation_proforma = NegotiationProformas::where('negotiation_id', $proforma->negotiationProformas->negotiation_id)->selectRaw('count(*) as count')->first();
        $negotiation_invoices = NegotiationInvoices::where('negotiation_id', $proforma->negotiationProformas->negotiation_id)->selectRaw('count(*) as count')->first();
        
        $proforma->proformaProducts()->delete();
        $proforma->negotiationProformas()->delete();
        if ($proforma->delete()) {
            if ($negotiation_proforma->count == 1 && $negotiation_invoices->count == 0) {
                $negotiation = Negotiation::where('id', $proforma->negotiationProformas->negotiation_id)->firstOrFail();
                 $negotiation->proformed_date = NULL;
                 $negotiation->selection_warehouse_date = NULL;
                 $negotiation->debug_date = NULL;
                 $negotiation->save();
            }

            return redirect()->route('proformas.index')->with('info', 'Borrado con exito');
          } 
        else{
            return redirect()->route('proformas.index')->with('info', 'Error, intente de nuevo');
        }
    }
}
