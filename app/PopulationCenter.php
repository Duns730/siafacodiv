<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PopulationCenter extends Model
{
    protected $fillable = [
        'municipality_id', 'name',
    ];

    protected $hidden = ['created_at', 'update_at'];

    public function municipality(){
    	return $this->belongsTo(Municipality::class);
    }
    public function locations(){
    	return $this->hasMany(Location::class);
    }    
    public function addresses(){
    	return $this->hasMany(Address::class);
    }
}
