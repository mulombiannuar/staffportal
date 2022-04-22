<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhonesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phones', function (Blueprint $table) {
            $table->id('phone_id');
            $table->integer('product_id');
            $table->string('name');
            $table->string('serial_number');
            $table->string('imei_number');
            $table->string('phone_number');
            $table->string('puk_1');
            $table->string('puk_2');
            $table->string('pin_1');
            $table->string('pin_2');
            $table->string('date_assigned');
            $table->string('date_purchased');
            $table->text('additional_info')->nullable();
            $table->integer('assigned_to');
            $table->integer('assigned_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phones');
    }
}