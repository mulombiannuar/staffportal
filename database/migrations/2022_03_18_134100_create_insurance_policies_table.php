<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInsurancePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insurance_policies', function (Blueprint $table) {
            $table->id('policy_id');
            $table->string('policy_no');
            $table->integer('reference');
            $table->integer('outpost');
            $table->integer('product');
            $table->integer('company');
            $table->integer('created_by');
            $table->integer('officer');
            $table->integer('status')->default(1);
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('client_id');
            $table->string('client_kra');
            $table->string('sum_issued');
            $table->string('premium');
            $table->string('date_issued');
            $table->string('date_expired');
            $table->string('cheque_no');
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
        Schema::dropIfExists('insurance_policies');
    }
}