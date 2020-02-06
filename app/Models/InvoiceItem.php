<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    public function taxes(){
        return $this->belongsToMany(Tax::class,'invoice_item_taxes');
    }

    public function item(){
        return $this->hasOne(Item::class,'id','item_id');
    }
}
