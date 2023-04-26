<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddOverdueHoursToCustomerTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_tickets', function (Blueprint $table) {
            $table->string('overdue_days')->default(0);
            $table->string('overdue_hours')->default(0);
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
            $table->dropColumn('overdue_days');
            $table->dropColumn('overdue_hours');
        });
    }
}
