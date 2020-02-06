<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends Model
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
            $builder->whereNull('companies.company_id');
        });
    }

    protected $casts = [
        'info' => 'collection'
    ];

    public function customer(){
        return $this->morphOne(Customer::class, 'parent');
    }

    public static function _save($data, $item=null){
        if(!$item){
            $item = new self();
        }
        if($item->table){
            $new_item = $item->replicate();
        }

        $item->name = $data['name'];
        $item->type = $data['type'];

        if($item->isDirty()){
            if($item->table){
                $new_item->company_id = $item->id;
                $new_item->save();
            }
        }
        $item->save();
        return $item;
    }



}
