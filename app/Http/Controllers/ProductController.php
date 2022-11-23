<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('id', 'ASC')->paginate(100);
        $total_products = Product::selectRaw('count(*) as count')->first();
        return view('products.index', compact('products', 'total_products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('products.create');
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
            'reference' => 'required|unique:products',
            'description' => 'required',
            'brand' => 'required',
            'list' => 'required|integer',
            'minimum_amount' => 'required|integer',
        ]);

        $product = new Product;
        $product->reference = strtoupper(e($request->reference));
        $product->description = strtoupper(e($request->description));
        $product->brand = strtoupper(e($request->brand));
        $product->list = e($request->list);
        $product->minimum_amount = e($request->minimum_amount);

        $urlimages = [];
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $nombre = time() . $image->getClientOriginalName();
                $ruta = public_path() . '/images';
                $image->move($ruta, $nombre);
                $urlimages[]['url'] = '/images/' . $nombre;

            }
        }

        $prices = [
                'price_a' => '0.00',
                'price_b' => '0.00',
                'price_c' => '0.00',
                'price_d' => '0.00',
                'price_e' => '0.00',
                'price_f' => '0.00',
                'price_g' => '0.00',
                'price_h' => '0.00',
                'price_i' => '0.00',
                'price_j' => '0.00',
                'price_k' => '0.00',
                'price_l' => '0.00',
                'price_m' => '0.00',
                'price_n' => '0.00',
                'price_o' => '0.00',
                'price_p' => '0.00',
                'price_q' => '0.00',
                'price_r' => '0.00',
        ];

        if ($product->save()) {
            $product->price()->create($prices);
            $product->images()->createMany($urlimages);
            return redirect()->route('products.show', $product->id)->with('info', 'Producto creado correctamente');
        }
        else{
            return redirect()->route('products.index')->with('info', 'Error, intente de nuevo');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::where('id', $id)->with('price', 'images')->firstOrFail();
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::where('id', $id)->with('images')->firstOrFail();
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if ($product->reference == $request->reference) {
            $role = 'required';
        }
        else{
            $role = 'required|unique:products';
        }
        
         $request->validate([    
            'reference' => $role,
            'description' => 'required',
            'brand' => 'required',
            'list' => 'required|integer',
            'minimum_amount' => 'required|integer',
        ]);

        $product->reference = strtoupper(e($request->reference));
        $product->description = strtoupper(e($request->description));
        $product->brand = strtoupper(e($request->brand));
        $product->list = e($request->list);
        $product->minimum_amount = e($request->minimum_amount);

        $urlimages = [];
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            foreach ($images as $image) {
                $nombre = time() . $image->getClientOriginalName();
                $ruta = public_path() . '/images';
                $image->move($ruta, $nombre);
                $urlimages[]['url'] = '/images/' . $nombre;
            }
        }

        if ($product->save()) {
            $product->images()->createMany($urlimages);
            return redirect()->route('products.show', $product->id)->with('info', 'Producto creado correctamente');
        }
        else{
            return redirect()->route('products.index')->with('info', 'Error, intente de nuevo');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Product::findOrFail($id)->delete()) {
              return back()->with('info', 'Borrado con exito');
          } 
        else{
            return back()->with('info', 'Error, intente de nuevo');
        }
    }

    public function massiveLoad()
    {
        return view('products.massiveLoad');
    }

    public function massiveUpdate()
    {
        return view('products.massiveUpdate');
    }
}
