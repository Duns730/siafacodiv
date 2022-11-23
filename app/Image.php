<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'url',
    ];

    protected $hidden = ['created_at', 'update_at'];

    public function imageable()
    {
    	return morphTo();
    }
}
