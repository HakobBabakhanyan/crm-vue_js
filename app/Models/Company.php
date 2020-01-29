<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    public function customers(){
        return $this->morphMany(Customer::class, 'parent','parent_type');
    }

    protected $casts = [
        'info' => 'collection'
    ];

    protected $appends = ['type'];

    public function getTypeAttribute(){
        return self::class;
    }

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
