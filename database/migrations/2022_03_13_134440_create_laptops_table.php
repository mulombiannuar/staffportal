<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaptopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laptops', function (Blueprint $table) {
            $table->id('laptop_id');
            $table->integer('product_id');
            $table->string('name');
            $table->string('manufacturer');
            $table->string('model');
            $table->string('serial_number');
            $table->string('operating_system');
            $table->string('supplier_name')->nullable();
            $table->string('os_key');
            $table->string('office_name');
            $table->string('office_key');
            $table->string('processor');
            $table->string('ram');
            $table->string('hdd_details');
            $table->string('display');
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
        Schema::dropIfExists('laptops');
    }
}