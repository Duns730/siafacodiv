<?php

namespace App\Http\Controllers;

use App\Seller;
use App\Address;
use Illuminate\Http\Request;

class SellerController extends Controller
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
        $sellers = Seller::orderBy('id', 'ASC')->with('address.state')->paginate(50);
        return view('sellers.index', compact('sellers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('sellers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([    
            'name' => 'required',
            'rif' => 'required',
            'phones' => 'required|max:40',
            'email' => 'required|email',
            'commission' => 'required|numeric',
            'state_id' => 'required|integer',
            'municipality_id' => 'required|integer',
            'population_center_id' => 'required|integer',
            'location_id' => 'required|integer',
        ]);

        $seller = new Seller;
        $seller->name = strtoupper(e($request->name));
        $seller->rif = strtoupper(e($request->rif));
        $seller->phones = e($request->phones);
        $seller->email = strtoupper(e($request->email));
        $seller->commission = $request->commission;

        $address = $request->all();

        if ($seller->save()) {
            $seller->address()->create($address);
            return redirect()->route('sellers.index')->with('info', 'Vendedor creado correctamente');
        }
        else{
            return redirect()->route('sellers.index')->with('info', 'Error, intente de nuevo');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $seller = Seller::where('id', $id)->with('address.state', 'address.municipality', 'address.populationCenter', 'address.location')->firstOrFail();
        //dd($seller);
        return view('sellers.show', compact('seller'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $seller = Seller::where('id', $id)->with('address.state', 'address.municipality', 'address.populationCenter', 'address.location')->firstOrFail();
        return view('sellers.edit', compact('seller'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, seller $seller)
    {
        //dd($request);
        $request->validate([    
            'name' => 'required',
            'rif' => 'required',
            'phones' => 'required|max:40',
            'email' => 'required|email',
            'commission' => 'required|numeric',
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
        

        $seller->name = strtoupper(e($request->name));
        $seller->rif = strtoupper(e($request->rif));
        $seller->phones = e($request->phones);
        $seller->email = strtoupper(e($request->email));
        $seller->commission = $request->commission;

        if ($seller->save()) {
            if (isset($address)) {
                $seller->address()->create($address); 
                Address::where('id', $seller->address->id)->delete();
            }
            return redirect()->route('sellers.show', $seller->id)->with('info', 'Vendedor actualizado correctamente');
        }
        else{
            return redirect()->route('sellers.index')->with('info', 'Error, intente de nuevo');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\seller  $seller
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         if (Seller::findOrFail($id)->delete()) {
              return back()->with('info', 'Borrado con exito');
          } 
        else{
            return back()->with('info', 'Error, intente de nuevo');
        }
    }
}
