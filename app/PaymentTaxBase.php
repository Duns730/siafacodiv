<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentTaxBase extends Model
{
    protected $fillable = [
        'payment_id', 'invoice_id', 'amount_paid', 'collection_commission',    
    ];

    protected $hidden = ['created_at', 'update_at'];

    public function invoice(){
    	return $this->belongsTo(Invoice::class);
    }

    public function payment(){
    	return $this->belongsTo(Payment::class);
    }
}
