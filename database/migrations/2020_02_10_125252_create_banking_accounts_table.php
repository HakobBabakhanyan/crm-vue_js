<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBankingAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banking_accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('banking_account_id')->unsigned()->nullable();
            $table->bigInteger('currency_id')->unsigned();
            $table->string('name');
            $table->integer('number');
            $table->float('balance');
            $table->string('bank_name');
            $table->string('bank_phone');
            $table->text('bank_address');
            $table->boolean('status')->default(0);
            $table->boolean('default')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('currency_id')->on('currencies')
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
        Schema::dropIfExists('banking_accounts');
    }
}
