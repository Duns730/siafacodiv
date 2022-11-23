<?php

namespace App\Http\Controllers;

use App\ClientPurchaseProforma;
use Illuminate\Http\Request;

class ClientPurchaseProformaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ClientPurchaseProforma  $clientPurchaseProforma
     * @return \Illuminate\Http\Response
     */
    public function show(ClientPurchaseProforma $clientPurchaseProforma)
    {
        return view('clientPurchaseProforma.show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ClientPurchaseProforma  $clientPurchaseProforma
     * @return \Illuminate\Http\Response
     */
    public function edit(ClientPurchaseProforma $clientPurchaseProforma)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ClientPurchaseProforma  $clientPurchaseProforma
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ClientPurchaseProforma $clientPurchaseProforma)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ClientPurchaseProforma  $clientPurchaseProforma
     * @return \Illuminate\Http\Response
     */
    public function destroy(ClientPurchaseProforma $clientPurchaseProforma)
    {
        //
    }
}
