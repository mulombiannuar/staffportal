<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSwitchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('switches', function (Blueprint $table) {
            $table->id('switch_id');
            $table->integer('product_id');
            $table->string('name');
            $table->string('serial_number');
            $table->string('supplier');
            $table->string('location');
            $table->string('model_no');
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
        Schema::dropIfExists('switches');
    }
}