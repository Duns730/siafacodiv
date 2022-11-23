<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'client_id', 'seller_id', 'factor', 'invoice_number', 'date', 'provisional', 'tax_base_dollar', 'tax_base_bolivar', 'iva_dollar', 'iva_bolivar', 'total_operation_dollar', 'total_operation_bolivar', 'status',     
    ];
    
    protected $hidden = ['created_at', 'update_at'];

   /* public function price(){
    	return $this->hasOne(Price::class);
    }*/
    public function invoiceProducts(){
    	return $this->hasMany(InvoiceProducts::class);
    }

    public function negotiationInvoices(){
        return $this->hasOne(NegotiationInvoices::class);
    }

    public function client(){
    	return $this->belongsTo(Client::class);
    }

    public function seller(){
    	return $this->belongsTo(Seller::class);
    } 

    public function clientPurchaseInvoice(){
        return $this->hasOne(ClientPurchaseInvoice::class);
    }

    public function paymentIva(){
        return $this->hasMany(PaymentIva::class);
    }
    
    public function paymentTaxBase(){
        return $this->hasMany(PaymentTaxBase::class);
    }
}
