<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NegotiationInvoices extends Model
{
    protected $fillable = [
        'negotiation_id', 'invoice_id',
    ];

    protected $hidden = ['created_at', 'update_at'];

    public function negotiation(){
    	return $this->belongsTo(Negotiation::class);
    }
    public function invoices(){
    	return $this->hasOne(Invoice::class, 'id');
    }
}
