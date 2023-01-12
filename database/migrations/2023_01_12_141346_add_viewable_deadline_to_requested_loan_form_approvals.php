<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewableDeadlineToRequestedLoanFormApprovals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requested_loan_form_approvals', function (Blueprint $table) {
            $table->integer('is_locked')->nullable();
            $table->string('viewable_deadline')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requested_loan_form_approvals', function (Blueprint $table) {
            $table->dropColumn('is_locked');
            $table->dropColumn('viewable_deadline');
        });
    }
}
