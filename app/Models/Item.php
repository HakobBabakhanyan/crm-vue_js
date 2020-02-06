<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{

    use SoftDeletes;

    public function taxes(){
        return $this->belongsToMany(Tax::class,'invoice_item_taxes');
    }

    public function category(){
        return $this->hasOne(ItemCategory::class,'id','category_id');
    }

    public static function _save($data,$item=null){
        if(!$item){
            $item = new self();
        }

        $item->name = $data['name'];
        $item->description = $data['description'];
        $item->sale_price = $data['sale_price'];
        $item->purchase_price = $data['purchase_price'];
        $item->category_id = $data['category_id']??null;

        $item->save();

        return $item;
    }
}
