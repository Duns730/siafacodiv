<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Truck extends Model
{
    protected $fillable = [
        'transport_id', 'model', 'license_plate',     
    ];
    
    protected $hidden = ['created_at', 'update_at'];

    public function transport(){
    	return $this->belongsTo(Transport::class);
    }
}
