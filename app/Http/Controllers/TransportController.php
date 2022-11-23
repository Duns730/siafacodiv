<?php

namespace App\Http\Controllers;

use App\Transport;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transports = Transport::orderBy('id', 'ASC')->paginate(25);
        return view('transports.index', compact('transports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('transports.create');
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
            'rif' => 'required|unique:transports',
            'minimun_freight' => 'required|numeric',
        ]);

        $transport = new Transport;
        $transport->name = strtoupper($request->name);
        $transport->rif = strtoupper(e($request->rif));
        $transport->minimun_freight = $request->minimun_freight;

        if ($transport->save()) {
            return redirect()->route('transports.show', $transport->id)->with('info', 'Transporte creado correctamente');
        }
        else{
            return redirect()->route('transports.index')->with('info', 'Error, intente de nuevo');
        }  
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Transport  $transport
     * @return \Illuminate\Http\Response
     */
    public function show(Transport $transport)
    {
        return view('transports.show', compact('transport'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Transport  $transport
     * @return \Illuminate\Http\Response
     */
    public function edit(Transport $transport)
    {
        return view('transports.edit', compact('transport'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Transport  $transport
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transport $transport)
    {
        if ($transport->rif == $request->rif) {
            $role = 'required';
        }
        else{
            $role = 'required|unique:transports';
        }
        $request->validate([    
            'name' => 'required',
            'rif' => $role,
            'minimun_freight' => 'required|numeric',
        ]);

        $transport->name = strtoupper($request->name);
        $transport->rif = strtoupper(e($request->rif));
        $transport->minimun_freight = $request->minimun_freight;

        if ($transport->save()) {
            return redirect()->route('transports.show', $transport->id)->with('info', 'Transporte creado correctamente');
        }
        else{
            return redirect()->route('transports.show', $transport->id)->with('info', 'Error, intente de nuevo');
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Transport  $transport
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transport $transport)
    {
        
    }
}
