<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceItemTaxesTable extends Migration
{
    /** $table->bigIncrements('id');
            $table->timestamps();
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_item_taxes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('invoice_item_id')->unsigned();
            $table->bigInteger('tax_id')->unsigned();
            $table->timestamps();
            $table->foreign('invoice_item_id')->on('invoice_items')
                ->references('id')->onDelete('cascade');
            $table->foreign('tax_id')->on('taxes')
                ->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoice_item_taxes');
    }
}
