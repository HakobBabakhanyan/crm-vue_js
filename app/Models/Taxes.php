<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Taxes extends Model
{
    const TYPE = [
        1 =>'Normal',
        2 =>'Inclusive',
        3 =>'Compound',
    ];

    public static function _save($data, $item = null)
    {
        if (!$item) {
            $item = new self();
        }

        $item->name = $data['name'];
        $item->rate = $data['rate'];
        $item->type = $data['type'];
        $item->status = $data['status'] ?? false;

        $item->save();

        return $item;
    }

    public function getTypeAttribute($value){
        return $this::TYPE[$value];
    }
}
