<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BankingAccount extends Model
{

    use SoftDeletes;

    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public static function create_or_save($data,$item = null){
        if (!$item)
        $item = new self();

        $item->name = $data['name'];
        $item->currency_id = $data['currency'];
        $item->number = $data['number'];
        $item->balance = $data['balance'];
        $item->bank_name = $data['bank_name'];
        $item->name = $data['name'];
        $item->bank_phone = $data['bank_phone'];
        $item->bank_address = $data['bank_address'];
        $item->status = $data['status']??null;
        $item->default = $data['default']??0;

        $item->save();

        return $item;
    }
}
