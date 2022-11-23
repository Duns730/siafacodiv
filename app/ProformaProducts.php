<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProformaProducts extends Model
{
    protected $fillable = [
        'product_id', 'proforma_id', 'position', 'quantity', 'unit_price_bolivar', 'total_price_dollar', 'total_price_bolivar',      
    ];
    
    protected $hidden = ['created_at', 'update_at'];

    public function proforma(){
    	return $this->belongsTo(Proforma::class);
    }
    public function product(){
    	return $this->belongsTo(Product::class);
    }
}
