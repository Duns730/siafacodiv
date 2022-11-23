<?php

namespace App\Http\Controllers;

use App\CreditNote;
use App\Invoice;
use App\Configuration;
use Illuminate\Http\Request;

class CreditNoteController extends Controller
{

    public function index()
    {
        $creditnotes = CreditNote::orderBy('id', 'ASC')->paginate(50);
        return view('creditnotes.index', compact('creditnotes'));
    }

    public function create()
    {
        return view('creditnotes.create');
    }

    public function show($id)
    {
        $credit_note = CreditNote::where('id', $id)->with('creditNoteProducts.invoiceProducts')->firstOrFail();
        $invoices = explode("-", $credit_note->invoices);
        $client = Invoice::where('invoice_number', $invoices[0])
                ->join('clients', 'clients.id', '=', 'invoices.client_id')
                ->join('sellers', 'sellers.id', '=', 'clients.seller_id')
                ->selectRaw('clients.name as client_name, sellers.name as seller_name')
                ->first();
        //dd($client);

        return view('creditnotes.show', compact('credit_note', 'client'));
    }

    public function printBolivar($id)
    {
        $configuration = Configuration::find([2])->all();
        $configurations = array_combine(array_column($configuration, 'key'), array_column($configuration, 'value'));
        $credit_note = CreditNote::where('id', $id)->with('creditNoteProducts.invoiceProducts')->firstOrFail();
        $invoices = explode("-", $credit_note->invoices);
        $client = Invoice::where('invoice_number', $invoices[0])
                ->join('clients', 'clients.id', '=', 'invoices.client_id')
                ->join('sellers', 'sellers.id', '=', 'clients.seller_id')
                ->selectRaw('clients.*, sellers.name as seller_name, sellers.id as seller_id')
                ->first();
       
        //return view('creditnotes.partials.printBolivar', compact('credit_note', 'client', 'configurations'));
        return \PDF::loadView('creditnotes.partials.printBolivar', compact('credit_note', 'client', 'configurations'))
                    ->setPaper('letter') //, 'landscape'
                    ->stream('(Nota de Crédito ' . $credit_note->note_number . ') .pdf');
        
    }
}
