<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'bank_id', 'reference', 'concept', 'amount',  'type',  'date', 'collection_commission',   
    ];

    protected $hidden = ['created_at', 'update_at'];

    public function paymentIva(){
    	return $this->hasMany(PaymentIva::class);
    }
    
    public function paymentTaxBase(){
        return $this->hasMany(PaymentTaxBase::class);
    }

    public function bank(){
    	return $this->belongsTo(Bank::class);
    }

}
