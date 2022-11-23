<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\CreditNote;
use App\CreditNoteProduct;

class CreditNoteController extends Controller
{
    public function store(Request $request)
    {
        //dd($request->data);
        $result = Validator::make($request->data, [
                'note_number'     =>['required', 'unique:credit_notes', 'integer'],
                'control_number'   => ['required'],
                'invoices' => ['required'],
                'date'          => ['required'],
                'products' => ['required', 'array'],
            ]);

        if ($result->fails()) {
                return response()->json([
                    'status' => 406,
                    'message' => "Error en datos ingresados",
                    'errors' => $result->errors()
                ]);
            }

        $credit_note = new CreditNote;
        $credit_note->note_number = e($request->data['note_number']);
        $credit_note->control_number = e($request->data['control_number']);
        $credit_note->invoices = e($request->data['invoices']);
        $credit_note->date = e($request->data['date']);
        $credit_note->tax_base_dollar = e($request->data['tax_base_dollar']);
        $credit_note->tax_base_bolivar = e($request->data['tax_base_bolivar']);
        $credit_note->iva_dollar = e($request->data['iva_dollar']);
        $credit_note->iva_bolivar = e($request->data['iva_bolivar']);
        $credit_note->total_operation_dollar = $request->data['total_operation_dollar'];
        $credit_note->total_operation_bolivar = e($request->data['total_operation_bolivar']);

        if ($credit_note->save()) {
            foreach ($request->data['products'] as $product) {
                CreditNoteProduct::create([
                    'credit_note_id' => $credit_note->id,
                    'invoice_product_id' => $product['invoice_product_id'],
                    'quantity' => $product['quantity'],
                    'total_price_bolivar' => $product['sub_total_bolivar'],
                    'total_price_dollar' => e($product['sub_total_dollar']),
                ]);
            }

            return response()->json([
                'status' => 201,
                'credit_note_id' => $credit_note->id,
            ]);
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
