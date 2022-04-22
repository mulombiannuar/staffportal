<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motors', function (Blueprint $table) {
            $table->id('motor_id');
            $table->integer('product_id');
            $table->string('name');
            $table->string('chassis_number');
            $table->string('mileage');
            $table->string('type');
            $table->string('color');
            $table->string('engine');
            $table->string('model');
            $table->string('reg_no');
            $table->string('build_year');
            $table->string('last_maintenance');
            $table->string('supplier');
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
        Schema::dropIfExists('motorbikes');
    }
}