<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = [
        'state_id', 'municipality_id', 'population_center_id', 'location_id',     
    ];
    protected $hidden = ['created_at', 'update_at'];

    public function state(){
    	return $this->belongsTo(State::class);
    }
    public function municipality(){
    	return $this->belongsTo(Municipality::class);
    }
    public function populationCenter(){
    	return $this->belongsTo(PopulationCenter::class);
    }
    public function location(){
    	return $this->belongsTo(Location::class);
    }

    public function addressable()
    {
        return morphTo();
    }

}
