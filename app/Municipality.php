<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipality extends Model
{
    protected $fillable = [
        'state_id', 'name',
    ];

    protected $hidden = ['created_at', 'update_at'];

    public function state(){
    	return $this->belongsTo(State::class);
    }
    public function populationcenters(){
    	return $this->hasMany(PopulationCenter::class);
    }    
    public function addresses(){
    	return $this->hasMany(Address::class);
    }
}
