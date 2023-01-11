<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestedLoanFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requested_loan_forms', function (Blueprint $table) {
            $table->id('request_id');
            $table->string('reference');
            $table->integer('request_loan_id')->nullable();
            $table->integer('product_id');
            $table->string('bimas_br_id');
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('national_id');
            $table->string('amount');
            $table->string('disbursment_date');
            $table->integer('requested_by');
            $table->text('officer_message');
            $table->string('date_requested');
            $table->integer('is_approved')->default(0);
            $table->integer('branch_id');
            $table->integer('outpost_id');
            $table->text('approval_message')->nullable();
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
        Schema::dropIfExists('requested_loan_forms');
    }
}
