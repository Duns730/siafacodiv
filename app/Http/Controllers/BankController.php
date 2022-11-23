<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banks = Bank::orderBy('id', 'ASC')->paginate(20);
        return view('banks.index', compact('banks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('banks.create');   
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
            'currency' => 'required',
        ]);

        $bank = new Bank;
        $bank->name = strtoupper(e($request->name));
        $bank->currency = e($request->currency);


        if ($bank->save()) {
            return redirect()->route('banks.index')->with('info', 'Banco creado correctamente');
        }
        else{
            return redirect()->route('banks.index')->with('info', 'Error, intente de nuevo');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        return redirect()->route('banks.index');
        //return view('banks.show'); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        return view('banks.edit', compact('bank')); 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
       // dd($request);

        $request->validate([    
            'name' => 'required',
            'currency' => 'required',
        ]);

        $bank->name = strtoupper(e($request->name));
        $bank->currency = e($request->currency);
        $bank->status = $request->status == 'on' ? true : false;


        if ($bank->save()) {
            return redirect()->route('banks.index')->with('info', 'Banco creado correctamente');
        }
        else{
            return redirect()->route('banks.index')->with('info', 'Error, intente de nuevo');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Bank  $bank
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Bank::findOrFail($id)->delete()) {
              return back()->with('info', 'Borrado con exito');
          } 
        else{
            return back()->with('info', 'Error, intente de nuevo');
        }
    }
}
