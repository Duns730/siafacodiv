<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'populationcenter_id', 'name',
    ];

    protected $hidden = ['created_at', 'update_at'];

    public function populationcenter(){
    	return $this->belongsTo(PopulationCenter::class);
    }
      
    public function addresses(){
    	return $this->hasMany(Address::class);
    }
}
