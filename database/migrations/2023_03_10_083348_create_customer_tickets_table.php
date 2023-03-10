<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_tickets', function (Blueprint $table) {
            $table->id('ticket_id');
            $table->string('ticket_uuid');
            $table->integer('customer_id');
            $table->integer('category_id');
            $table->integer('source_id');
            $table->string('date_raised');
            $table->text('message');
            $table->integer('officer_id');
            $table->integer('ticket_closed')->default(0);
            $table->integer('customer_sent_survey')->default(0);
            $table->integer('customer_responded_survey')->default(0);
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
        Schema::dropIfExists('customer_tickets');
    }
}
