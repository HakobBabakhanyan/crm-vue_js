<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

//    public function items(){
//        return $this->belongsToMany(Item::class,'invoice_items')
//            ->withTimestamps()
//            ->withPivot('quantity');
//    }

    public function invoiceItems(){
        return $this->hasMany(InvoiceItem::class);
    }

    public function item_tax(){

        $this->loadMissing('items');
        dd();
        InvoiceItemTax::query()
            ->whereIn('invoice_item_id',$this->items->pluck('id'))
            ->get();
        dd();
        return ;
    }

    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public static function _save($data){

        $item = self::query()->first();

        $item->invoice_date = Carbon::make($data['invoice_date']);
        $item->due_date = Carbon::make($data['due_date']);
        $item->currency_id = $data['currency_id'];
        $item->customer_id = $data['customer_id'];
        $item->category_id = $data['category_id'];
        $item->invoice_number = $data['invoice_number'];
        $item->order_number = $data['order_number'];
        $item->description = $data['description'];
        $item->save();
        $item->items()->sync(self::getSyncArray($data['data']));
        $item->taxSync($data['data']);

        return $item;

    }

    protected  function taxSync($data){

       $invoiceItem = InvoiceItem::query()->where('invoice_id',$this->id)
            ->whereIn('item_id',array_map(function ($a){
                return $a['item_id'];
            },$data))->get();

       $taxes = array_column($data,'tax','item_id');

        foreach ($invoiceItem as $item){
           foreach ($taxes[$item->item_id]??[] as $tax){
               InvoiceItemTax::query()
                   ->updateOrCreate(['invoice_item'=>$item->id],['tax_id'=>$tax]);
           }
       }
        return true;
    }



    protected static function getSyncArray($items){
        $sync = array();
        foreach ($items as $item){
            $sync[$item['item_id']] = ['quantity'=>$item['quantity']];
        }
        return $sync;
    }
}
