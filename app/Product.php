<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference', 'description', 'brand', 'list', 'minimum_amount',     
    ];
    
    protected $guarded = [];
    protected $dates = ['deleted_at'];
    protected $hidden = ['created_at', 'update_at'];

    public function price(){
    	return $this->hasOne(Price::class);
    }

    public function proformaProducts(){
        return $this->hasMany(ProformaProducts::class);
    }

    public function images(){
        return $this->morphMany('App\Image', 'imageable');
    }

    public function purchaseProducts(){
        return $this->hasMany(PurchaseProducts::class);
    }

}
