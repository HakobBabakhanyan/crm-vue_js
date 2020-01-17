<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{

    protected $casts = [
      'info' => 'collection'
    ];

    public static function _save($data, $item=null){
        if(!$item){
            $item = new self();
        }
        $item->name = $data['name'];
        $item->type = $data['type'];
        $item->logo = $data['img']??null;
        $info['address'] = $data['address']??null;
        $info['site'] = $data['site']??null;
        $info['contacts'] = $data['contacts']??null;
        $item->info = $info;

        $item->save();
        return $item;
    }
}
