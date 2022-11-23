<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NegotiationProformas extends Model
{
    protected $fillable = [
        'negotiation_id', 'proforma_id',
    ];

    protected $hidden = ['created_at', 'update_at'];

    public function negotiation(){
    	return $this->belongsTo(Negotiation::class);
    }
    public function proforma(){
    	return $this->hasOne(Proforma::class, 'id');
    }
}
