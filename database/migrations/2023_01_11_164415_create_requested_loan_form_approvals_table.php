<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestedLoanFormApprovalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requested_loan_form_approvals', function (Blueprint $table) {
            $table->id('approval_id');
            $table->integer('request_id');
            $table->integer('approved_by');
            $table->integer('approval_status');
            $table->integer('loan_form_id')->nullable();
            $table->string('date_approved');
            $table->text('approval_message');
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
        Schema::dropIfExists('requested_loan_form_approvals');
    }
}
