<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceProducts extends Model
{
    protected $fillable = [
        'invoice_id', 'product_id', 'reference', 'description', 'brand', 'quantity', 'unit_price_dollar', 'unit_price_bolivar',  'total_price_dollar',  'total_price_bolivar',       
    ];
    
    protected $hidden = ['created_at', 'update_at'];

    public function invoice(){
    	return $this->belongsTo(Invoice::class);
    }
    public function product(){
    	return $this->belongsTo(Product::class);
    }
    public function creditNoteProduct(){
        return $this->hasOne(CreditNoteProduct::class);
    }
}
