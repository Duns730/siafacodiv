<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    protected $fillable = [
        'price_a', 'price_b', 'price_c', 'price_d', 'price_e', 'price_f', 'price_g', 'price_h', 'price_i', 'price_j', 'price_k', 'price_l', 'price_m','price_n','price_o','price_p','price_q','price_r'
    ];
    
    protected $dates = ['deleted_at'];
    protected $hidden = ['created_at', 'update_at'];

    public function product(){
    	return $this->hasOne(Product::class);
    }
}
