<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Purchase;
use App\Proforma;
use App\NegotiationProformas;
use App\Negotiation;
use App\ProformaProducts;
use App\ClientPurchaseProforma;
use App\ClientPurchaseInvoice;

class ProformaController extends Controller
{
    

    public function ListProducts(Request $request) //id de la proforma
    {
        return response()->json(
            ProformaProducts::join('products', 'proforma_products.product_id','=','products.id')
                                ->join('prices', 'products.id','=','prices.product_id')
                                ->select('prices.'.$request->data['type_price'].' as price',
                                        'products.*', 'proforma_products.quantity')
                                ->where('proforma_id', $request->data['id'])
                                ->orderBy('position', 'ASC')
                                ->get()
            );
    }

    public function store(Request $request)
    {
        $proforma = new Proforma;
        $proforma->factor = e($request->data['factor']);
        $proforma->tax_base_dollar = e($request->data['tax_base_dollar']);
        $proforma->tax_base_bolivar = e($request->data['tax_base_bolivar']);
        $proforma->iva_dollar = e($request->data['iva_dollar']);
        $proforma->iva_bolivar = e($request->data['iva_bolivar']);
        $proforma->total_operation_dollar = $request->data['total_operation_dollar'];
        $proforma->total_operation_bolivar = e($request->data['total_operation_bolivar']);
        $proforma->total_items = e($request->data['total_items']);
        $proforma->type_price = e($request->data['type_price']);
        $proforma->provisional = $request->data['provisional'];
        
        if ( $proforma->save() && NegotiationProformas::create([ 'negotiation_id' => e($request->data['negotiation_id']), 'proforma_id' => $proforma->id]) ) {
            $position = 1;
            
            $negotiation = Negotiation::where('id', $request->data['negotiation_id'])->firstOrFail();
            if (empty($negotiation->proformed_date)) {
                $negotiation->proformed_date = date('Y-m-d H:i:s');
                $negotiation->save();
            }
            
            foreach ($request->data['products'] as $product) {
                ProformaProducts::create([
                    'product_id' => $product['id'],
                    'proforma_id' => $proforma->id,
                    'position' => $position++,
                    'quantity' => $product['quantity'],
                    'unit_price_bolivar' => $product['price_bolivar'],
                    'total_price_dollar' => $product['sub_total_dollar'],
                    'total_price_bolivar' => $product['sub_total_bolivar'],
                ]);
            }
            return response()->json([
                'status' => 201,
                'id' => $proforma->id,
            ]);
        } 
    }

    public function updateEdit(Request $request)
    {

        $proforma = Proforma::where('id', $request->data['id'])->firstOrFail();
        $proforma->factor = e($request->data['factor']);
        $proforma->tax_base_dollar = e($request->data['tax_base_dollar']);
        $proforma->tax_base_bolivar = e($request->data['tax_base_bolivar']);
        $proforma->iva_dollar = e($request->data['iva_dollar']);
        $proforma->iva_bolivar = e($request->data['iva_bolivar']);
        $proforma->total_operation_dollar = $request->data['total_operation_dollar'];
        $proforma->total_operation_bolivar = e($request->data['total_operation_bolivar']);
        $proforma->total_items = e($request->data['total_items']);
        $proforma->type_price = e($request->data['type_price']);
        $proforma->provisional = $request->data['provisional'];

        $negotiation_proforma = NegotiationProformas::where('id', $request->data['negotiation_proforma_id'])->firstOrFail();
        $negotiation_proforma->negotiation_id = e($request->data['negotiation_id']);
        $negotiation_proforma->proforma_id = $proforma->id;
        
        if ( $proforma->save() && $negotiation_proforma->save()) {

            $negotiation = Negotiation::where('id', $request->data['negotiation_id'])->firstOrFail();
           if (empty($negotiation->proformed_date)) {
                $negotiation->proformed_date = date('Y-m-d H:i:s');
                $negotiation->save(); 
            }
            else{
                $negotiation->save(); 
            }
          
            ProformaProducts::where('proforma_id', $proforma->id)->delete();
            $position = 1;  
            foreach ($request->data['products'] as $product) {
                ProformaProducts::create([
                    'product_id' => $product['id'],
                    'proforma_id' => $proforma->id,
                    'position' => $position++,
                    'quantity' => $product['quantity'],
                    'unit_price_bolivar' => $product['price_bolivar'],
                    'total_price_dollar' => $product['sub_total_dollar'],
                    'total_price_bolivar' => $product['sub_total_bolivar'],
                ]);
            }
                return response()->json([
                    'status' => 201,
                    'id' => $proforma->id,
                ]);
        } 
    }

    public function updateDebug(Request $request)
    {
        $negotiation = Negotiation::where('id', $request->data['negotiation_id'])->firstOrFail();
        if (empty($negotiation->selection_warehouse_date)) {
                return response()->json([
                    'status' => 406,
                    'message' => 'No puede depurar esta proforma hasta que se haya enviado a Almacén(Selección).',
                ]);
            }

        $proforma = Proforma::where('id', $request->data['id'])->firstOrFail();
        $proforma->factor = e($request->data['factor']);
        $proforma->tax_base_dollar = e($request->data['tax_base_dollar']);
        $proforma->tax_base_bolivar = e($request->data['tax_base_bolivar']);
        $proforma->iva_dollar = e($request->data['iva_dollar']);
        $proforma->iva_bolivar = e($request->data['iva_bolivar']);
        $proforma->total_operation_dollar = $request->data['total_operation_dollar'];
        $proforma->total_operation_bolivar = e($request->data['total_operation_bolivar']);
        $proforma->total_items = e($request->data['total_items']);
        $proforma->type_price = e($request->data['type_price']);
        $proforma->provisional = $request->data['provisional'];

        $negotiation_proforma = NegotiationProformas::where('id', $request->data['negotiation_proforma_id'])->firstOrFail();
        $negotiation_proforma->negotiation_id = e($request->data['negotiation_id']);
        $negotiation_proforma->proforma_id = $proforma->id;
        
        if ( $proforma->save() && $negotiation_proforma->save()) {

           if (empty($negotiation->debug_date)) {
                $negotiation->debug_date = date('Y-m-d H:i:s');
                $negotiation->save(); 
            }
            else{
                $negotiation->save(); 
            }
          
            ProformaProducts::where('proforma_id', $proforma->id)->delete();
            $position = 1;  
            foreach ($request->data['products'] as $product) {
                ProformaProducts::create([
                    'product_id' => $product['id'],
                    'proforma_id' => $proforma->id,
                    'position' => $position++,
                    'quantity' => $product['quantity'],
                    'unit_price_bolivar' => $product['price_bolivar'],
                    'total_price_dollar' => $product['sub_total_dollar'],
                    'total_price_bolivar' => $product['sub_total_bolivar'],
                ]);
            }
                return response()->json([
                    'status' => 201,
                    'id' => $proforma->id,
                ]);
        } 
    }


    public function storeProvisional(Request $request)
    {
        $result = $this->checkRemainingQuantity($request->data);
        if (!empty($result)) {
            return response()->json([
                    'status' => 406,
                    'message' => $result,
                ]);
        }  

        $proforma = new Proforma;
        $proforma->factor = e($request->data['factor']);
        $proforma->tax_base_dollar = e($request->data['tax_base_dollar']);
        $proforma->tax_base_bolivar = e($request->data['tax_base_bolivar']);
        $proforma->iva_dollar = e($request->data['iva_dollar']);
        $proforma->iva_bolivar = e($request->data['iva_bolivar']);
        $proforma->total_operation_dollar = $request->data['total_operation_dollar'];
        $proforma->total_operation_bolivar = e($request->data['total_operation_bolivar']);
        $proforma->total_items = e($request->data['total_items']);
        $proforma->type_price = e($request->data['type_price']);
        $proforma->provisional = $request->data['provisional'];
        
        if ( $proforma->save() && NegotiationProformas::create([ 'negotiation_id' => e($request->data['negotiation_id']), 'proforma_id' => $proforma->id]) ) {
            $position = 1;
            
            $negotiation = Negotiation::where('id', $request->data['negotiation_id'])->firstOrFail();
            if (empty($negotiation->proformed_date)) {
                $negotiation->proformed_date = date('Y-m-d H:i:s');
                $negotiation->save();
            }
            
            foreach ($request->data['products'] as $product) {
                ProformaProducts::create([
                    'product_id' => $product['id'],
                    'proforma_id' => $proforma->id,
                    'position' => $position++,
                    'quantity' => $product['quantity'],
                    'unit_price_bolivar' => $product['price_bolivar'],
                    'total_price_dollar' => $product['sub_total_dollar'],
                    'total_price_bolivar' => $product['sub_total_bolivar'],
                ]);
            }

            ClientPurchaseProforma::create([
                    'purchase_id' => e($request->data['purchase_id']),
                    'client_id' => e($request->data['client_id']),
                    'proforma_id' => $proforma->id
                ]);

            return response()->json([
                'status' => 201,
                'id' => $proforma->id,
            ]);
        } 
    }

    public function updateEditProvisional(Request $request)
    {
        $result = $this->checkRemainingQuantity($request->data);
        if (!empty($result)) {
            return response()->json([
                    'status' => 406,
                    'message' => $result,
                ]);
        }  

        $proforma = Proforma::where('id', $request->data['id'])->firstOrFail();
        $proforma->factor = e($request->data['factor']);
        $proforma->tax_base_dollar = e($request->data['tax_base_dollar']);
        $proforma->tax_base_bolivar = e($request->data['tax_base_bolivar']);
        $proforma->iva_dollar = e($request->data['iva_dollar']);
        $proforma->iva_bolivar = e($request->data['iva_bolivar']);
        $proforma->total_operation_dollar = $request->data['total_operation_dollar'];
        $proforma->total_operation_bolivar = e($request->data['total_operation_bolivar']);
        $proforma->total_items = e($request->data['total_items']);
        $proforma->type_price = e($request->data['type_price']);
        $proforma->provisional = $request->data['provisional'];

        $negotiation_proforma = NegotiationProformas::where('id', $request->data['negotiation_proforma_id'])->firstOrFail();
        $negotiation_proforma->negotiation_id = e($request->data['negotiation_id']);
        $negotiation_proforma->proforma_id = $proforma->id;
        
        if ( $proforma->save() && $negotiation_proforma->save()) {
            
            $client_purchase_proforma = ClientPurchaseProforma::where('proforma_id', $proforma->id)->firstOrFail();
            $client_purchase_proforma->purchase_id = $request->data['purchase_id'];
            $client_purchase_proforma->client_id = $request->data['client_id'];
            $client_purchase_proforma->save();

            $negotiation = Negotiation::where('id', $request->data['negotiation_id'])->firstOrFail();
            if (empty($negotiation->proformed_date)) {
                $negotiation->proformed_date = date('Y-m-d H:i:s');
                $negotiation->save(); 
            }
            else{
                $negotiation->save(); 
            }
          
            ProformaProducts::where('proforma_id', $proforma->id)->delete();
            $position = 1;  
            foreach ($request->data['products'] as $product) {
                ProformaProducts::create([
                    'product_id' => $product['id'],
                    'proforma_id' => $proforma->id,
                    'position' => $position++,
                    'quantity' => $product['quantity'],
                    'unit_price_bolivar' => $product['price_bolivar'],
                    'total_price_dollar' => $product['sub_total_dollar'],
                    'total_price_bolivar' => $product['sub_total_bolivar'],
                ]);
            }
                return response()->json([
                    'status' => 201,
                    'id' => $proforma->id,
                ]);
        } 
    }

    public function updateDebugProvisional(Request $request)
    {
        $result = $this->checkRemainingQuantity($request->data);
        if (!empty($result)) {
            return response()->json([
                    'status' => 406,
                    'message' => $result,
                ]);
        }  

        $negotiation = Negotiation::where('id', $request->data['negotiation_id'])->firstOrFail();
        if (empty($negotiation->selection_warehouse_date)) {
                return response()->json([
                    'status' => 406,
                    'message' => 'No puede depurar esta proforma hasta que se haya enviado a Almacén(Selección).',
                ]);
            }

        $proforma = Proforma::where('id', $request->data['id'])->firstOrFail();
        $proforma->factor = e($request->data['factor']);
        $proforma->tax_base_dollar = e($request->data['tax_base_dollar']);
        $proforma->tax_base_bolivar = e($request->data['tax_base_bolivar']);
        $proforma->iva_dollar = e($request->data['iva_dollar']);
        $proforma->iva_bolivar = e($request->data['iva_bolivar']);
        $proforma->total_operation_dollar = $request->data['total_operation_dollar'];
        $proforma->total_operation_bolivar = e($request->data['total_operation_bolivar']);
        $proforma->total_items = e($request->data['total_items']);
        $proforma->type_price = e($request->data['type_price']);
        $proforma->provisional = $request->data['provisional'];

        $negotiation_proforma = NegotiationProformas::where('id', $request->data['negotiation_proforma_id'])->firstOrFail();
        $negotiation_proforma->negotiation_id = e($request->data['negotiation_id']);
        $negotiation_proforma->proforma_id = $proforma->id;
        
        if ( $proforma->save() && $negotiation_proforma->save()) {
            
            $client_purchase_proforma = ClientPurchaseProforma::where('proforma_id', $proforma->id)->firstOrFail();
            $client_purchase_proforma->purchase_id = $request->data['purchase_id'];
            $client_purchase_proforma->client_id = $request->data['client_id'];
            $client_purchase_proforma->save();
            
           if (empty($negotiation->debug_date)) {
                $negotiation->debug_date = date('Y-m-d H:i:s');
                $negotiation->save(); 
            }
            else{
                $negotiation->save(); 
            }
          
            ProformaProducts::where('proforma_id', $proforma->id)->delete();
            $position = 1;  
            foreach ($request->data['products'] as $product) {
                ProformaProducts::create([
                    'product_id' => $product['id'],
                    'proforma_id' => $proforma->id,
                    'position' => $position++,
                    'quantity' => $product['quantity'],
                    'unit_price_bolivar' => $product['price_bolivar'],
                    'total_price_dollar' => $product['sub_total_dollar'],
                    'total_price_bolivar' => $product['sub_total_bolivar'],
                ]);
            }
                return response()->json([
                    'status' => 201,
                    'id' => $proforma->id,
                ]);
        } 
    }


    public function checkRemainingQuantity($data)
    {
        $product_stock_update = 'Productos con existencia actualizada: <ul>';
        $verificate = false;
        foreach ($data['products'] as $product) {
            $product_proformas = ClientPurchaseProforma::where('client_purchase_proformas.purchase_id', $data['purchase_id'])
                ->where('proforma_products.product_id', $product['id'])
                ->join('proformas', 'proformas.id', '=', 'client_purchase_proformas.proforma_id')
                ->join('proforma_products', 'proformas.id', '=', 'proforma_products.proforma_id')
                ->selectRaw('sum(proforma_products.quantity) as quantity')
                ->first();
            $product_invoices = ClientPurchaseInvoice::where('client_purchase_invoices.purchase_id', $data['purchase_id'])
                ->where('invoice_products.product_id', $product['id'])
                ->join('invoices', 'invoices.id', '=', 'client_purchase_invoices.invoice_id')
                ->join('invoice_products', 'invoices.id', '=', 'invoice_products.invoice_id')
                ->selectRaw('sum(invoice_products.quantity) as quantity')
                ->first();
            $amount_purchase = Purchase::join('purchase_products', 'purchase_products.purchase_id', '=', 'purchases.id')
                ->where('purchases.id', $data['purchase_id'])
                ->where('purchase_products.product_id', $product['id'])
                ->select('quantity')
                ->first();

            $previous_proforma = NegotiationProformas::where('negotiation_proformas.id', $data['negotiation_proforma_id'])
                ->where('proforma_products.product_id', $product['id'])
                ->join('proformas', 'proformas.id', '=', 'negotiation_proformas.proforma_id')
                ->join('proforma_products', 'proforma_products.proforma_id', '=', 'proformas.id')
                ->select('quantity')
                ->first();
            //dd(empty($previous_proforma) ? 0 : $previous_proforma->quantity);
            $quantity_stock = $amount_purchase->quantity - $product_invoices->quantity - ($product_proformas->quantity - intval(empty($previous_proforma) ? 0 : $previous_proforma->quantity));

            if($quantity_stock - $product['quantity'] < 0){
                $verificate = true;

                $product_stock_update .= '<li>'.$product['reference'].' => '.$quantity_stock.'</li>';
            }
        }
        $product_stock_update .= '</ul>';

        if ($verificate) {
            return $product_stock_update; 
        }
        else{
            return '';
        }
        
    }
}
