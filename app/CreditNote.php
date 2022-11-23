<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CreditNote extends Model
{
    protected $fillable = [
        'note_number', 'control_number', 'date', 'tax_base_dollar', 'tax_base_bolivar', 'iva_dollar', 'iva_bolivar', 'total_operation_dollar', 'total_operation_bolivar',     
    ];
    
    protected $hidden = ['created_at', 'update_at'];

   /* public function price(){
    	return $this->hasOne(Price::class);
    }*/
    public function creditNoteProducts(){
    	return $this->hasMany(CreditNoteProduct::class);
    }
}
