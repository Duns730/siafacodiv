<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreightTabulator extends Model
{
    protected $fillable = [
        'transport_id', 'population_center_id', 'percentage',     
    ];
    
    protected $hidden = ['created_at', 'update_at'];

    public function transport(){
    	return $this->belongsTo(Transport::class);
    }
}
