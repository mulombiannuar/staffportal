<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReturnDateToRequestedLoanForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requested_loan_forms', function (Blueprint $table) {
            $table->string('return_date')->nullable();
            $table->integer('is_original')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requested_loan_forms', function (Blueprint $table) {
            $table->dropColumn('return_date');
            $table->dropColumn('is_original');
        });
    }
}
