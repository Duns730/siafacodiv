<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'seller_id', 'rif', 'name', 'fiscal_address', 'phones', 'email', 'withholding_tax',   
    ];
    
    protected $dates = ['deleted_at'];
    protected $hidden = ['created_at', 'update_at'];

    public function seller(){
    	return $this->belongsTo(Seller::class);
    } 
    public function negotiations(){
        return $this->hasMany(Negotiation::class);
    }  
    public function address(){
        return $this->morphOne('App\Address', 'addressable');
    }
    public function clientPurchaseProformas(){
        return $this->hasMany(ClientPurchaseProforma::class);
    }
    public function invoices(){
        return $this->hasMany(Invoice::class);
    } 

}
