<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductsImport;
use App\Product;
use App\Price;
use App\Purchase;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function byListPrice(Request $request)
    {   
        $purchase_products = Product::leftJoin('prices', 'products.id', '=', 'prices.product_id')
                ->leftJoin('purchase_products', 'purchase_products.product_id', '=', 'products.id')
                ->leftJoin('purchases', 'purchases.id', '=', 'purchase_products.purchase_id')
                ->selectRaw('products.id')
                ->where('purchases.status', 'OPEN')
                ->orderBy('products.description', 'ASC')
                ->get();
        $purchase_products_id = [];
        foreach ($purchase_products as $key => $purchase_product) {
            array_push($purchase_products_id, $purchase_product->id);
        }   

        $products = Product::leftJoin('prices', 'products.id', '=', 'prices.product_id')
                //->leftJoin('purchase_products', 'purchase_products.product_id', '=', 'products.id')
                ->selectRaw('prices.'.$request->data['type_price'].' as price, products.*')
                ->whereNotIn('products.id', $purchase_products_id)
                ->orderBy('products.description', 'ASC')
                ->get();

        return response()->json($products);
    }

    public function index()
    {
        return response()->json(
            Product::orderBy('id', 'ASC')->select('id', 'reference', 'description', 'brand')->get()
            );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function massiveLoad(Request $request)
    {
        //dd($request->file);
        $products_import = Excel::ToArray(new ProductsImport, $request->file);

        foreach ($products_import[0] as $key => $product) {

            $result = Validator::make($product, [
                'reference'     =>['required'],
                'description'   => ['required'],
                'brand' => [''],
                'list'          => ['required', 'min:1', 'integer'],
                'minimum_amount' => ['required', 'min:1', 'integer'],
                'price_a'       => ['required', 'numeric'],
                'price_b'       => ['required', 'numeric'],
                'price_c'       => ['required', 'numeric'],
                'price_d'       => ['required', 'numeric']
            ]);

            if ($result->fails()) { 
                $row = $key + 2;
                return response()->json([
                    'status' => 406,
                    'message' => $product['reference'] . ' Fila Nro ' . $row,
                    'errors' => $result->errors()
                ]);
            }

            if (Product::where('reference', $product['reference'])->first() != null) {
                $products_import[0][$key]['existence'] = 1;
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
            if (!$product['existence']) {
                $counter++;
                $product_create = Product::create([
                    'reference' => $product['reference'],
                    'description' => $product['description'],
                    'brand' => $product['brand'],
                    'list' => $product['list'],
                    'minimum_amount' => $product['minimum_amount']
                ]);
                //dd($product_create->id);
                //if (isset($product_create->id)) {
                    $product_create->price()->create([
                        //'product_id' => $product_create->id,
                        'price_a' => $product['price_a'],
                        'price_b' => $product['price_b'],
                        'price_c' => $product['price_c'],
                        'price_d' => $product['price_d'],
                        'price_e' => 0.00,
                        'price_f' => $product['price_b'],
                        'price_g' => 0.00,
                        'price_h' => 0.00,
                        'price_i' => 0.00,
                        'price_j' => 0.00,
                        'price_k' => 0.00,
                        'price_l' => 0.00,
                        'price_m' => 0.00,
                        'price_n' => 0.00,
                        'price_o' => 0.00,
                        'price_p' => 0.00,
                        'price_q' => 0.00,
                        'price_r' => 0.00,
                    ]);
                //}
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

    public function massiveUpdate(Request $request)
    {
        $cols = json_decode($request->cols);
        $rules['description']   = array_search('description', $cols) > -1 ? ['required'] : [''] ;
        $rules['brand']         = array_search('brand', $cols) > -1 ? ['required'] : [''] ;
        $rules['list']          = array_search('list', $cols) > -1 ? ['required', 'min:1', 'integer'] : [''] ;
        $rules['minimum_amount'] = array_search('minimum_amount', $cols) > -1 ? ['required', 'min:1', 'integer'] : [''] ;
        $rules['price_a']       = array_search('price_a', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_b']       = array_search('price_b', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_c']       = array_search('price_c', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_d']       = array_search('price_d', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_e']       = array_search('price_e', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_g']       = array_search('price_g', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_h']       = array_search('price_h', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_i']       = array_search('price_i', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_j']       = array_search('price_j', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_k']       = array_search('price_k', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_l']       = array_search('price_l', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_m']       = array_search('price_m', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_n']       = array_search('price_n', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_o']       = array_search('price_o', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_p']       = array_search('price_p', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_q']       = array_search('price_q', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;
        $rules['price_r']       = array_search('price_r', $cols) > -1 ? ['required', 'min:0.001', 'numeric'] : [''] ;

        $products_import = Excel::ToArray(new ProductsImport, $request->file);
        foreach ($products_import[0] as $key => $product) {

            $result = Validator::make($product, [
                'reference'     => ['required'],
                'description'   => $rules['description'],
                'brand'         => $rules['brand'],
                'list'          => $rules['list'],
                'minimum_amount' => $rules['minimum_amount'],
                'price_a'       => $rules['price_a'],
                'price_b'       => $rules['price_b'],
                'price_c'       => $rules['price_c'],
                'price_d'       => $rules['price_d'],
                'price_e'       => $rules['price_e'],
                'price_g'       => $rules['price_g'],
                'price_h'       => $rules['price_h'],
                'price_i'       => $rules['price_i'],
                'price_j'       => $rules['price_j'],
                'price_k'       => $rules['price_k'],
                'price_l'       => $rules['price_l'],
                'price_m'       => $rules['price_m'],
                'price_n'       => $rules['price_n'],
                'price_o'       => $rules['price_o'],
                'price_p'       => $rules['price_p'],
                'price_q'       => $rules['price_q'],
                'price_r'       => $rules['price_r'],
            ]);

            if ($result->fails()) {
                $row = $key + 2;
                return response()->json([
                    'status' => 406,
                    'message' => $product['reference'] . ' Fila Nro ' . $row,
                    'errors' => $result->errors()
                ]);
            }
            $product_sys = Product::where('reference', $product['reference'])->first();
            if ($product_sys != null) {
                $products_import[0][$key]['existence'] = 1;
                $products_import[0][$key]['id'] = $product_sys->id;
            }
            else{
                $products_import[0][$key]['existence'] = 0;
            }
        }
        return response()->json(
            $products_import
        );
    }

    public function massiveUpdateStore(Request $request)
    {
        //dd($request->data);
        $counter = 0;
        $not_registered = [];

        foreach ($request->data['products'] as $product) {
            if ($product['existence']) {
                $data = [];
                foreach ($request->data['cols'] as $col) {
                    $data[$col] = $product[$col];
                    if ($col == 'price_b') {
                        $data['price_f'] = $product[$col];
                    }
                }

                $product_update = Product::where('id', $product['id'])->first();
                $product_update->fill($data);
                //dd($data);

                $price_update = Price::where('product_id', $product['id'])->first();
                $price_update->fill($data);
                if ($price_update->save() && $product_update->save()) {
                    $counter++;
                }
                else{
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
