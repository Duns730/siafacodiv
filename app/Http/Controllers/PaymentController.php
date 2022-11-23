<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Invoice;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
   
    public function index()
    {
        $payments_tax_base = Payment::orderBy('id', 'DESC')->with('paymentTaxBase', 'bank')->paginate(100);
        $payments_iva = Payment::orderBy('id', 'DESC')->with('paymentIva', 'bank')->paginate(100);
        foreach ($payments_iva as $key => $payment) {
            $payments_iva[$key]->amount_paid = 0;
            foreach ($payment->paymentIva as  $payment_iva) {
                $payments_iva[$key]->amount_paid += $payment_iva->amount_paid;
            }
            if (count($payment->paymentIva) < 1) {
                unset($payments_iva[$key]);
            }
        }

        foreach ($payments_tax_base as $key => $payment) {
            $payments_tax_base[$key]->amount_paid = $payments_tax_base[$key]->collection_commission;
            foreach ($payment->paymentTaxBase as  $payment_tax_base) {
                $payments_tax_base[$key]->amount_paid += $payment_tax_base->amount_paid;
            }
            if (count($payment->paymentTaxBase) < 1) {
                unset($payments_tax_base[$key]);
            }
        }
        return view('payments.index', compact('payments_tax_base', 'payments_iva'));
    }


    public function processIva()
    {
        return view('payments.processIva');
    }

    public function processTaxBase()
    {
        return view('payments.processTaxBase');
    }


    public function showIva($id)
    {
        $payment = Payment::where('id', $id)->with('paymentIva.invoice', 'bank')->firstOrFail();
        $payment->amount_paid = 0;

        foreach ($payment->paymentIva as $payment_iva) {
            $payment->amount_paid -= $payment_iva->amount_paid;
        }
        return view('payments.showIva', compact('payment'));
    }

    public function showTaxBase($id)
    {
        $payment = Payment::where('id', $id)->with('paymentTaxBase.invoice', 'bank')->firstOrFail();
        $payment->amount_paid = $payment->collection_commission;

        foreach ($payment->paymentTaxBase as $payment_tax_base) {
            $payment->amount_paid += $payment_tax_base->amount_paid;
        }
        return view('payments.showTaxBase', compact('payment'));
    }
    
}
