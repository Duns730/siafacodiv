<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditNoteProduct extends Model
{
     protected $fillable = [
        'credit_note_id', 'invoice_product_id', 'quantity', 'total_price_bolivar', 'total_price_dollar',
    ];
    
    protected $hidden = ['created_at', 'update_at'];

    public function creditNote(){
    	return $this->belongsTo(CreditNote::class);
    }

    public function invoiceProducts(){
    	return $this->hasOne(InvoiceProducts::class, 'id', 'invoice_product_id');
    }
}

