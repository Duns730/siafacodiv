<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Payment;
use App\PaymentIva;
use App\PaymentTaxBase;
use App\Invoice;

class PaymentController extends Controller
{

    public function store(Request $request)
    {
        $rules_withholding_tax = [];
        $rules_bank_id = [];
        if ($request->data['payment'] == 'iva') {
            $rules_withholding_tax = ['required', 'integer'];
        }
        if ($request->data['type'] != 'nota de credito') {
            $rules_bank_id = ['required', 'integer'];
        }
        
        $result = Validator::make($request->data, [
            'bank_id' => $rules_bank_id,
            'type' => ['required'],
            'reference' => ['required'],
            'concept' => ['required'],
            'withholding_tax' =>  $rules_withholding_tax,
            'amount_payment' => ['required', 'numeric'],
            'date' => ['required'],
            'collection_commission' => ['numeric'],
            'invoices_to_pay' => ['required', 'array']
        ]);

        if ($result->fails()) {
            return response()->json([
                'status' => 406,
                'message' => 'Debe ingresar todos los datos que se solicita para poder procesar el pago.',
            ]);
        }

        $payment = Payment::where('reference', $request->data['reference'])
                    ->where('date', $request->data['date'])
                    ->first();
                    
        if (empty($payment)) {
            $payment = new Payment;
            $payment->bank_id = e($request->data['bank_id']);
            $payment->reference = strtoupper(e($request->data['reference']));
            $payment->concept = strtoupper(e($request->data['concept']));
            $payment->amount = e($request->data['amount_payment']);
            $payment->type = strtoupper(e($request->data['type']));
            $payment->collection_commission = e($request->data['collection_commission']);
            $payment->date = e($request->data['date']);
        }
        else{
            $payment->concept = strtoupper(e($request->data['concept']));
        }        

        if ($payment->save()) {

            if ($request->data['payment'] == 'iva') {
                foreach ($request->data['invoices_to_pay'] as $invoices_to_pay) {
                    PaymentIva::create([
                            'invoice_id' => $invoices_to_pay['id'],
                            'payment_id' => $payment->id,
                            'withholding_tax' => $request->data['withholding_tax'],
                            'amount_paid' => $invoices_to_pay['paid_out'],
                    ]); 
                }
            }
            else if ($request->data['payment'] == 'tax_base') {
                foreach ($request->data['invoices_to_pay'] as $invoices_to_pay) {
                    PaymentTaxBase::create([
                            'invoice_id' => $invoices_to_pay['id'],
                            'payment_id' => $payment->id,
                            'amount_paid' => $invoices_to_pay['paid_out'],
                    ]);
                    $this->verificatePaymentInvoice($invoices_to_pay['id']);
                }   
            }
            else{
                return response()->json([
                    'status' => 406,
                    'message' => 'No se pudo procesar el pago, intente de nuevo.',
                ]);
            }
        
            return response()->json([
                'status' => 201,
                'message' => 'Pago procesado con exito.',
            ]);
        }
        else{
             return response()->json([
                'status' => 406,
                'message' => 'No se pudo procesar el pago, intente de nuevo.',
            ]);
        }
    }

    public function verificatePaymentInvoice($invoice_id)
    {
        $invoice = Invoice::where('id', $invoice_id)->firstOrFail();
        $payment = PaymentTaxBase::where('invoice_id', $invoice_id)->selectRaw('SUM(amount_paid) as amount_paid')->first();
        if ($invoice->tax_base_dollar == $payment->amount_paid) {
            $invoice->status = "CANCELADA";
            $invoice->save();
        }
    }
}
