<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{

    protected  $casts=[
        'invoice_date'=>'date',
        'due_date'=>'date'
    ];
    public function items(){
        return $this->belongsToMany(Item::class,'invoice_items')
            ->withTimestamps()
            ->withPivot('quantity');
    }

    public function invoiceItems(){
        return $this->hasMany(InvoiceItem::class);
    }

    public function category(){
        return $this->belongsTo(InvoiceCategory::class);
    }


    public function currency(){
        return $this->belongsTo(Currency::class);
    }

    public function customer(){
        return $this->belongsTo(Customer::class);
    }

    public static function _save($data,$item = null){

        if(!$item) $item = new self();

        $item->invoice_date = Carbon::make($data['invoice_date']);
        $item->due_date = Carbon::make($data['due_date']);
        $item->currency_id = $data['currency_id'];
        $item->customer_id = $data['customer_id'];
        $item->category_id = $data['category_id'];
        $item->invoice_number = $data['invoice_number'];
        $item->order_number = $data['order_number'];
        $item->description = $data['description'];
        $item->discount = $data['discount'];
        $item->save();
        $item->items()->sync(self::getSyncArray($data['items']));
        $item->taxSync($data['items']);

        return $item;

    }

    protected  function taxSync($data){

       $invoiceItem = InvoiceItem::query()->where('invoice_id',$this->id)
           ->get();

       $taxes = array_column($data,'tax','item_id');

        foreach ($invoiceItem as $item){
            if($taxes[$item->item_id])
           foreach ($taxes[$item->item_id] as $tax){
               InvoiceItemTax::query()
                   ->updateOrInsert(
                       ['invoice_item_id'=>$item->id],
                       ['invoice_item_id'=>$item->id,
                        'tax_id'=>$tax
                       ]);
           }
            else InvoiceItemTax::query()->where('invoice_item_id',$item->id)->delete();

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
