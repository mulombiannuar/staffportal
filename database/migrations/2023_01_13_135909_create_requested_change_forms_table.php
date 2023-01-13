<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRequestedChangeFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('requested_change_forms', function (Blueprint $table) {
            $table->id('request_id');
            $table->string('reference');
            $table->string('bimas_br_id');
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('national_id');
            $table->string('date_changed');
            $table->integer('requested_by');
            $table->text('officer_message');
            $table->string('date_requested');
            $table->integer('branch_id');
            $table->integer('outpost_id');
            $table->string('return_date')->nullable();
            $table->integer('is_original')->default(0);
            $table->integer('is_completed')->default(0);
            $table->integer('requested_form_id')->nullable();
            $table->integer('is_approved')->nullable();
            $table->integer('approved_by')->nullable();
            $table->string('date_approved')->nullable();
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
        Schema::dropIfExists('requested_change_forms');
    }
}
