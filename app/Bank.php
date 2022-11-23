<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = [
        'name', 'money', 'status',    
    ];

    protected $hidden = ['created_at', 'update_at'];

    public function payments(){
    	return $this->hasMany(Payment::class);
    }
}
