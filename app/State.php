<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'name',
    ];

    protected $hidden = ['created_at', 'update_at'];

    public function municipalities(){
    	return $this->hasMany(Municipality::class);
    }

    public function addresses(){
        return $this->morphOne('App\Address', 'addressable');
    }
}
