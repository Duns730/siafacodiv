<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    protected $fillable = [
        'rif', 'name', 'minimun_freight',     
    ];
    
    protected $hidden = ['created_at', 'update_at'];

    public function drivers(){
    	return $this->hasMany(Driver::class);
    }
    public function truck(){
    	return $this->hasMany(Truck::class);
    }
    public function FreightTabulator(){
    	return $this->hasMany(FreightTabulator::class);
    }
}
