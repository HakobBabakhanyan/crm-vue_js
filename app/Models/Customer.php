<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{

    const TYPE = [
        'PERSONS' => Person::class,
        'COMPANIES' => Company::class
    ];


    public function parentable(){
        return $this->guessBelongsToRelation();
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
}
