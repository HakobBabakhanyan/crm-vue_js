<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persons extends Model
{
    protected $casts = [
        'info' => 'collection'
    ];



    public function customers(){
        return $this->morphMany(Customers::class, 'parent','parent_type');
    }

    protected $appends = ['type'];


    public function getTypeAttribute(){
        return self::class;
    }

    public function companies(){
        return $this->belongsToMany(Companies::class);
    }

    public static function _save($data, $item=null){
        if(!$item){
            $item = new self();
        }
        $item->name = $data['name'];
        $item->image = $data['img']??null;
        $info['address'] = $data['address']??null;
        $info['contacts'] = $data['contacts']??null;
        $item->info = $info;

        $item->save();

        if($item){
            $item->companies()->sync($data['selected']??[]);
        }

        return $item;
    }
}
