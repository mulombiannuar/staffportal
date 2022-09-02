<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id('customer_id');
            $table->integer('campaign_id');
            $table->integer('officer_id');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('residence');
            $table->string('business');
            $table->text('customer_message');
            $table->integer('has_activated')->default(0);
            $table->text('officer_message')->nullable();
            $table->integer('responder_id')->nullable();
            $table->integer('issue_sorted')->default(0);
            $table->text('admin_message')->nullable();
            $table->integer('branch_id');
            $table->integer('outpost_id');
            $table->integer('created_by');
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
        Schema::dropIfExists('customers');
    }
}