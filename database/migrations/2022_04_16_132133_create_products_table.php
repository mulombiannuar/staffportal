<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id('product_id');
            $table->integer('category'); #
            $table->integer('outpost'); #
            $table->integer('officer'); #
            $table->string('purchase_price');#
            $table->string('disposal_price');#
            $table->integer('client_name');#
            $table->integer('client_id');#
            $table->integer('mobile_no');
            $table->string('loan_amount');
            $table->string('loan_balance');
            $table->string('principal_amount');
            $table->string('product_name');#
            $table->string('slug');
            $table->string('chassis_number');#
            $table->string('mileage');#
            $table->string('type');#
            $table->string('color');#
            $table->string('engine');#
            $table->string('reg_no');#
            $table->string('condition');#
            $table->string('location');#
            $table->string('images');
            $table->text('additional_info')->nullable();
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
        Schema::dropIfExists('products');
    }
}