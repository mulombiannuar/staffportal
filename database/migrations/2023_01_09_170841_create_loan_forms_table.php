<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoanFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loan_forms', function (Blueprint $table) {
            $table->id('form_id');
            $table->integer('product_id');
            $table->integer('client_id');
            $table->integer('filing_type_id');
            $table->integer('file_number');
            $table->string('amount');
            $table->string('disbursment_date');
            $table->string('cheque_no')->nullable();
            $table->string('payee');
            $table->string('file_name');
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
        Schema::dropIfExists('loan_forms');
    }
}
