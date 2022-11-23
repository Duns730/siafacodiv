<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    protected $fillable = [
        'transport_id', 'identity_card', 'name',     
    ];
    
    protected $hidden = ['created_at', 'update_at'];

    public function transport(){
    	return $this->belongsTo(Transport::class);
    }
}
