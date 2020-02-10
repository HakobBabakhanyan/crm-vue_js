<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('invoice_id')->unsigned()->nullable();
            $table->bigInteger('category_id')->unsigned();
            $table->bigInteger('currency_id')->unsigned();
            $table->bigInteger('customer_id')->unsigned();
            $table->integer('discount')->default(0);
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('invoice_number');
            $table->string('order_number');
            $table->string('description');
            $table->integer('status')->default(0);

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('category_id')->on('invoice_categories')
                ->references('id')->onDelete('cascade');
            $table->foreign('currency_id')->on('currencies')
                ->references('id')->onDelete('cascade');
            $table->foreign('customer_id')->on('customers')
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
        Schema::dropIfExists('invoices');
    }
}
