<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PurchaseProducts extends Model
{
    protected $fillable = [
        'product_id', 'purchase_id', 'quantity',      
    ];
    
    protected $hidden = ['created_at', 'update_at'];

    public function purchase(){
    	return $this->belongsTo(Purchase::class);
    }
    public function product(){
    	return $this->belongsTo(Product::class);
    }
    public function separatedProducts(){
        return $this->hasMany(SeparatedProducts::class);
    }
}
