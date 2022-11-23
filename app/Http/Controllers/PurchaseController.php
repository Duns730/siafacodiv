<?php

namespace App\Http\Controllers;

use App\Purchase;
use App\PurchaseProducts;
use App\ClientPurchaseInvoice;
use App\ClientPurchaseProforma;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $purchases = Purchase::orderBy('id', 'DESC')->paginate(20);
        //$total_purchases = Purchase::selectRaw('count(*) as count')->first();
        return view('purchases.index', compact('purchases'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('purchases.create');
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
            'document_number' => 'required',
            'date' => 'required',
        ]);

        $purchase = new Purchase;
        $purchase->title = strtoupper(e($request->title));
        $purchase->document_number = strtoupper(e($request->document_number));
        $purchase->date = e($request->date);

        if ($purchase->save()) {
            return redirect()->route('purchases.show', $purchase->id)->with('info', 'Compra creada correctamente');
        }
        else{
            return redirect()->route('purchases.index')->with('info', 'Error, intente de nuevo');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $purchase = Purchase::where('id', $id)->with('purchaseProducts.product')->firstOrFail();

        $products_proformas = ClientPurchaseProforma::where('client_purchase_proformas.purchase_id', $id)
                ->join('proformas', 'proformas.id', '=', 'client_purchase_proformas.proforma_id')
                ->join('proforma_products', 'proformas.id', '=', 'proforma_products.proforma_id')
                ->select(
                        'proforma_products.product_id',
                        'proforma_products.quantity as quantity_proforma')
                ->get();

        $products_invoices = ClientPurchaseInvoice::where('client_purchase_invoices.purchase_id', $id)
                ->join('invoices', 'invoices.id', '=', 'client_purchase_invoices.invoice_id')
                ->join('invoice_products', 'invoices.id', '=', 'invoice_products.invoice_id')
                ->select(
                        'invoice_products.product_id',
                        'invoice_products.quantity as quantity_proforma')
                ->get();
                   
        $quantity_proforma = 0;
        foreach ($purchase->purchaseProducts as $keyPP =>  $product) {
            foreach ($products_proformas as $key => $product_separated) {
                if ($product->product->id == $product_separated->product_id) {
                    $quantity_proforma += $product_separated->quantity_proforma;
                    unset($products_proformas[$key]);
                }
            }
            foreach ($products_invoices as $key => $product_separated) {
                if ($product->product->id == $product_separated->product_id) {
                    $quantity_proforma += $product_separated->quantity_proforma;
                    unset($products_invoices[$key]);
                }
            }

            $purchase->purchaseProducts[$keyPP]->quantity_proforma = $quantity_proforma;
            $quantity_proforma = 0;
        }

        return view('purchases.show', compact('purchase'));
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $purchase = Purchase::where('id', $id)->firstOrFail();
        return view('purchases.edit', compact('purchase'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        $request->validate([    
            'title' => 'required',
            'document_number' => 'required',
            'date' => 'required',
        ]);

        $purchase->title = strtoupper(e($request->title));
        $purchase->document_number = strtoupper(e($request->document_number));
        $purchase->date = e($request->date);
        if (isset($request->status)) {
            $purchase->status = 'OPEN';
        }
        else{
            $purchase->status = 'CLOSE';
        }

        if ($purchase->save()) {
            return redirect()->route('purchases.show', $purchase->id)->with('info', 'Compra actualizada correctamente');
        }
        else{
            return redirect()->route('purchases.show', $purchase->id)->with('info', 'Error, intente de nuevo');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $purchase_products = PurchaseProducts::where('purchase_id', $id)->selectRaw('count(*) as count')->first();
            if ($purchase_products->count < 1) {
                if (Purchase::findOrFail($id)->delete()) {
                return back()->with('info', 'Borrado con exito');
              } 
            else{
                return back()->with('info', 'Error, intente de nuevo');
            }
        }
        else{
            return back()->with('info', 'Error, La comprar no se puede borrar mientras tenga productos asociados.');
        }    
    }

    public function load($id)
    {
        $purchase = Purchase::where('id', $id)->firstOrFail();
        if ($purchase->status == 'OPEN') {
            return view('purchases.loadProducts', compact('purchase'));
        }
        return abort(404);
    }

    public function massiveLoad($id)
    {
        return view('purchases.massiveLoad', compact('id'));
    }
}
