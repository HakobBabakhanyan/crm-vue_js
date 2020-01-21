<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{

    public function category(){
        return $this->hasOne(ItemCategories::class,'id','categories_id');
    }

    public static function _save($data,$item=null){
        if(!$item){
            $item = new self();
        }

        $item->name = $data['name'];
        $item->description = $data['description'];
        $item->sale_price = $data['sale_price'];
        $item->purchase_price = $data['purchase_price'];
        $item->categories_id = $data['categories_id'];

        $item->save();

        return $item;
    }
}
