<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientPurchaseProforma extends Model
{
    protected $fillable = [
        'purchase_id', 'client_id', 'proforma_id',     
    ];
    
    protected $hidden = ['created_at', 'update_at'];

    public function client(){
    	return $this->belongsTo(Client::class);
    }
    public function purchase(){
        return $this->belongsTo(Purchase::class);
    }
    public function proforma(){
        return $this->hasOne(Proforma::class);
    }
}
