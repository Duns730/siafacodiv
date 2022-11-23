<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proforma extends Model
{
    protected $fillable = [
        'factor', 'tax_base_dollar', 'tax_base_bolivar', 'iva_dollar', 'iva_bolivar', 'total_operation_dollar', 'total_operation_bolivar', 'total_items', 'type_price', 'provisional',     
    ];
    
    protected $hidden = ['created_at', 'update_at'];

    public function proformaProducts(){
    	return $this->hasMany(ProformaProducts::class);
    }

    public function negotiationProformas(){
        return $this->hasOne(NegotiationProformas::class);
    }
    public function clientPurchaseProforma(){
        return $this->hasOne(ClientPurchaseProforma::class);
    }
}
