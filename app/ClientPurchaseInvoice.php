<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPurchaseInvoice extends Model
{
    protected $fillable = [
        'purchase_id', 'invoice_id',     
    ];
    
    protected $hidden = ['created_at', 'update_at'];

    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }
    public function invoice(){
        return $this->hasOne(Invoice::class);
    }
}
