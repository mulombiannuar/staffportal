<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppraisalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appraisals', function (Blueprint $table) {
            $table->id('appraisal_id');
            $table->text('clients');
            $table->integer('expense_id');
            $table->string('date');
            $table->string('amount_spent');
            $table->string('journey_from');
            $table->string('venue');
            $table->string('start_time');
            $table->string('end_time');
            $table->text('additional_info');
            $table->string('transport_means');
            $table->string('motor_regno')->nullable();
            $table->string('mileage_before')->nullable();
            $table->string('mileage_after')->nullable();
            $table->string('fuel_consumption')->nullable();
            $table->string('attachment')->nullable();
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
        Schema::dropIfExists('appraisals');
    }
}