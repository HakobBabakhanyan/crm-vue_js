<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{
    public static function _save($data, $item=null){
        if(!$item){
            $item = new self();
        }
        $item->name = $data['name'];
        $item->type = $data['type'];

        $item->save();
        return $item;
    }
}
