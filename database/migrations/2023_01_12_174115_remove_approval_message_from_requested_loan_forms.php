<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveApprovalMessageFromRequestedLoanForms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requested_loan_forms', function (Blueprint $table) {
            $table->dropColumn(['approval_message']);
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
            //
        });
    }
}
