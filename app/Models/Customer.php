<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    const TYPE = [
        'PERSONS' => Person::class,
        'COMPANIES' => Company::class
    ];

    protected $appends=['name'];


    public function parent(){
        return $this->morphTo();
    }

    public static function _save($data){

        if(isset(self::TYPE[$data['type']])){
            $item = self::where([['parent_id',$data['selected']],['parent_type', self::TYPE[$data['type']]]])->first();
            if(!$item){
                $item = new self();
            }
            $item->parent_id = $data['selected'];
            $item->parent_type = self::TYPE[$data['type']];

            $item->save();
            return $item;
        }

    }

    public function getNameAttribute(){
        return $this->parent->name ?? null;
    }
}
