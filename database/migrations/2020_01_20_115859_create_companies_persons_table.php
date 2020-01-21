<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesPersonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies_persons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('companies_id')->unsigned();
            $table->bigInteger('persons_id')->unsigned();
            $table->timestamps();
            $table->foreign('companies_id')->on('companies')->references('id')->onDelete('cascade');
            $table->foreign('persons_id')->on('persons')->references('id')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('companies_persons');
    }
}
