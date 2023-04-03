<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTicketClosureCommentToCustomerTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_tickets', function (Blueprint $table) {
            $table->integer('closed_by')->nullable();
            $table->text('closure_comment')->nullable();
            $table->string('date_closed')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_tickets', function (Blueprint $table) {
            $table->dropColumn('closed_by');
            $table->dropColumn('closure_comment');
            $table->dropColumn('date_closed');
        });
    }
}
