<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $casts = [
        'info' => 'collection'
    ];


    public function customer(){
        return $this->morphOne(Customer::class, 'parent');
    }

    protected $appends = ['type'];


    public function getTypeAttribute(){
        return self::class;
    }

    public function companies(){
        return $this->belongsToMany(Company::class);
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
