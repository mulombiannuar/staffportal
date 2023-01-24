<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_loans', function (Blueprint $table) {
            $table->id();
            $table->string('client_id');
            $table->string('account_id');
            $table->string('product_id');
            $table->string('application_id');
            $table->string('loan_amount');
            $table->string('loan_series');
            $table->string('disbursment_date');
            $table->string('application_date');
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
        Schema::dropIfExists('client_loans');
    }
}
