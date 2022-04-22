<?php

use App\Models\Shop\Cart;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id');
            $table->string('bid_number');
            $table->foreignIdFor(Cart::class, 'cart_id');
            $table->integer('customer_id');
            $table->string('location');
            $table->string('city');
            $table->string('county');
            $table->string('payment');
            $table->string('outpost');
            $table->string('date');
            $table->integer('order_chosen')->default(0);
            $table->integer('chosen_by')->nullable();
            $table->string('date_chosen')->nullable();
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
        Schema::dropIfExists('orders');
    }
}