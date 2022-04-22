<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupVisitationLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_visitation_loans', function (Blueprint $table) {
            $table->id('loan_id');
            $table->integer('visit_id');
            $table->string('client_id');
            $table->string('client_name');
            $table->string('loan_product');
            $table->string('loan_amount');
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
        Schema::dropIfExists('group_visitation_loans');
    }
}