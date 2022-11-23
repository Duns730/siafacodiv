<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Negotiation extends Model
{
    protected $fillable = [
        'client_id', 'user_id', 'title', 'details', 'days_interval', 'payment_installments', 'effective_percentage', 'transfer_percentage', 'proformed_date', 'selection_warehouse_date', 'debug_date', 'invoice_date', 'iva_payment_date', 'warehouse_packing_date', 'dispatch_date', 'deliver_date', 'full_payment',
    ];

    protected $hidden = ['created_at', 'update_at'];

    public function user(){
    	return $this->belongsTo(User::class);
    }

    public function client(){
    	return $this->belongsTo(Client::class);
    }
    public function negotiationProformas(){
        return $this->hasMany(NegotiationProformas::class);
    }
    public function negotiationInvoices(){
        return $this->hasMany(NegotiationInvoices::class);
    }
}
