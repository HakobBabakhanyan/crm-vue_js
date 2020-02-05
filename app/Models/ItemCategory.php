<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemCategory extends Model
{
    use SoftDeletes;
    public static function _save($data,$item=null){
        if(!$item){
            $item = new self();
        }

        $item->name = $data['name'];

        $item->save();

        return $item;
    }
}
