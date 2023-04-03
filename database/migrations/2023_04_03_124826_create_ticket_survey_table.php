<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketSurveyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_survey', function (Blueprint $table) {
            $table->id();
            $table->integer('ticket_id');
            $table->integer('sent_by');
            $table->string('ticket_uuid');
            $table->string('date_sent');
            $table->string('survey_message');
            $table->string('survey_link');
            $table->string('date_responded')->nullable();
            $table->string('ip_address')->nullable();
            $table->text('customer_response')->nullable();
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
        Schema::dropIfExists('ticket_survey');
    }
}
