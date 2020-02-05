<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use SoftDeletes;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('real', function (Builder $builder) {
            $builder->whereNull('people.person_id');
        });
    }
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
        }else {
            $new_item = $item->replicate();
        }

        $item->name = $data['name'];
        $item->image = $data['img']??null;
        $info['address'] = $data['address']??null;
        $info['contacts'] = $data['contacts']??null;
        $item->info =  $item->info;

        if($item->isDirty()){
            if($item->table){
                $new_item->person_id = $item->id;
                $new_item->save();
            }
        }
        $item->save();
        if($item){
            $item->companies()->sync($data['selected']??[]);
        }

        return $item;
    }
}
