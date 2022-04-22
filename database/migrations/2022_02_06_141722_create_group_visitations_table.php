<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupVisitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_visitations', function (Blueprint $table) {
            $table->id('visit_id');
            $table->json('groups');
            $table->integer('expense_id');
            $table->string('date');
            $table->string('transport_means');
            $table->string('amount_spent');
            $table->string('attachment')->nullable();
            $table->string('motor_regno')->nullable();
            $table->string('mileage_before')->nullable();
            $table->string('mileage_after')->nullable();
            $table->string('fuel_consumption')->nullable();
            $table->string('loans_applied');
            $table->string('new_members');
            $table->text('additional_info')->nullable();
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
        Schema::dropIfExists('group_visitations');
    }
}