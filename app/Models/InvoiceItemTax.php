<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItemTax extends Model
{
    protected $fillable = ['invoice_item','tax_id'];
}
