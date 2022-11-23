<?php

namespace App\Http\Controllers\Api;

use App\Purchase;
use App\Product;
use App\PurchaseProducts;
use App\ClientPurchaseProforma;
use App\ClientPurchaseInvoice;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Http\Controllers\Controller;
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
        return response()->json(
            Purchase::orderBy('date', 'DESC')->select('id', 'title', 'date', 'document_number')->get()
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        PurchaseProducts::where('purchase_id', $request->data['purchase_id'])->delete();
        foreach ($request->data['products'] as $product) {
            PurchaseProducts::create([
                'product_id' => $product['id'],
                'purchase_id' => $request->data['purchase_id'],
                'quantity' => $product['quantity']
            ]);
        }
        return response()->json([
            'status' => 201,
        ]);
    }

    public function totalize(Request $request)
    {
        PurchaseProducts::where('purchase_id', $request->data['purchase_id'])->delete();
        foreach ($request->data['products'] as $product) {
            PurchaseProducts::create([
                'product_id' => $product['id'],
                'purchase_id' => $request->data['purchase_id'],
                'quantity' => $product['quantity']
            ]);
        }

        $purchase = Purchase::where('id', $request->data['purchase_id'])->firstOrFail();
        $purchase->status = 'CLOSE';
        $purchase->save();

        return response()->json([
            'status' => 201,
        ]);
    }


    public function getProductsControlQuantity($id)
    {
        return response()->json(
            PurchaseProducts::where('purchase_products.purchase_id', $id)
                ->join('products', 'products.id','=','purchase_products.product_id')
                ->join('prices', 'products.id','=','prices.product_id')
                ->select('prices.price_f as price', 'products.*', 'purchase_products.quantity')
                ->get()
        );
    }

    public function getProductsProformas($id)
    {
        $products = PurchaseProducts::where('purchase_products.purchase_id', $id)
                ->join('products', 'products.id','=','purchase_products.product_id')
                ->join('prices', 'products.id','=','prices.product_id')
                ->select('prices.price_f as price', 'products.*', 'purchase_products.quantity')
                ->get();

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
        foreach ($products as $keyP =>  $product) {
            foreach ($products_proformas as $key => $product_separated) {
                if ($product->id == $product_separated->product_id) {
                    $quantity_proforma += $product_separated->quantity_proforma;
                    unset($products_proformas[$key]);
                }
            }
            foreach ($products_invoices as $key => $product_separated) {
                if ($product->id == $product_separated->product_id) {
                    $quantity_proforma += $product_separated->quantity_proforma;
                    unset($products_invoices[$key]);
                }
            }

            $products[$keyP]->quantity -= $quantity_proforma;
            $quantity_proforma = 0;
        }
        return response()->json($products);
    }

    public function massiveLoad(Request $request)
    {
        $products_import = Excel::ToArray(new ProductsImport, $request->file);
        foreach ($products_import[0] as $key => $product) {

            $result = Validator::make($product, [
                'reference'     =>['required'],
                'quantity'   => ['required', 'min:1', 'integer']
            ]);

            if ($result->fails()) {
                $row = $key + 2;
                return response()->json([
                    'status' => 406,
                    'message' => $product['reference'] . ' Fila Nro ' . $row,
                    'errors' => $result->errors()
                ]);
            }

            $product_sys = Product::where('reference', $product['reference'])->with('price')->first();
            if ($product_sys != null) {
                $products_import[0][$key]['existence'] = 1;
                $products_import[0][$key]['id'] = $product_sys->id;
                $products_import[0][$key]['description'] = $product_sys->description;
                $products_import[0][$key]['brand'] = $product_sys->brand;
                $products_import[0][$key]['price_f'] = $product_sys->price->price_f;
            }
            else{
                $products_import[0][$key]['existence'] = 0;
            }
        }
        return response()->json(
            $products_import
        );
    }

    public function massiveLoadStore(Request $request)
    {
        $counter = 0;
        $not_registered = [];
        foreach ($request->data['products'] as $product) {
            if ($product['existence']) {
                $counter++;
                $purchase_products_create = PurchaseProducts::create([
                    'product_id' => $product['id'],
                    'purchase_id' => $request->data['purchase_id'],
                    'quantity' => $product['quantity'],
                ]);
                if (!isset($purchase_products_create->id)) {
                    array_push($not_registered, $product);
                }
            }
            else{
                array_push($not_registered, $product);
            }
        }
        return response()->json([
                    'status' => 201,
                    'number_registered_products' => $counter,
                    'products_not_registered' => $not_registered
                ]);
    }
}
