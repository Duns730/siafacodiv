<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'title', 'document_number', 'date',   'status',    
    ];
    
    protected $hidden = ['created_at', 'update_at'];

   /* public function price(){
    	return $this->hasOne(Price::class);
    }*/
    public function purchaseProducts(){
    	return $this->hasMany(PurchaseProducts::class);
    }
    public function clientPurchaseProformas(){
        return $this->hasMany(ClientPurchaseProforma::class);
    }

    public function clientPurchaseInvoices(){
        return $this->hasMany(ClientPurchaseInvoice::class);
    }
    
}
