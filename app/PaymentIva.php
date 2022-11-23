<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentIva extends Model
{
    protected $fillable = [
        'payment_id', 'invoice_id', 'withholding_tax', 'amount_paid',     
    ];

    protected $hidden = ['created_at', 'update_at'];

    public function invoice(){
    	return $this->belongsTo(Invoice::class);
    }

    public function payment(){
    	return $this->belongsTo(Payment::class);
    }
}
