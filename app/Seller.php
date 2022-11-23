<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Seller extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'rif', 'name', 'phones', 'email', 'commission',     
    ];
    
    protected $dates = ['deleted_at'];
    protected $hidden = ['created_at', 'update_at'];

    public function clients(){
    	return $this->hasMany(Client::class);
    }

    public function address(){
        return $this->morphOne('App\Address', 'addressable');
    }
    public function invoices(){
        return $this->hasMany(Invoice::class);
    }
}
