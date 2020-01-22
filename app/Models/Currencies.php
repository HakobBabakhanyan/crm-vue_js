<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    public static function _save($data, $item = null)
    {
        if (!$item) {
            $item = new self();
        }

        $item->name = $data['name'];
        $item->code = $data['code'];
        $item->rate = $data['rate'];
        $item->status = $data['status'] ?? false;
        $item->default = $data['default'] ?? false;


        $item->save();

        return $item;
    }

    public function setDefaultAttribute($value)
    {
        if ($value) {
            self::query()->where('default', 1)->update(['default' => 0]);
            $this->attributes['rate'] = 1;
        }
        $this->attributes['default'] = $value;
    }
}
