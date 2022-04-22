<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_expenses', function (Blueprint $table) {
            $table->id('expense_id');
            $table->integer('activity_type');
            $table->integer('user_id');
            $table->integer('outpost_id');
            $table->string('date');
            $table->integer('status')->default(1);
            $table->integer('approver1')->nullable();
            $table->string('approver1_date')->nullable();
            $table->string('approver1_msg')->nullable();
            $table->integer('approver2')->nullable();
            $table->string('approver2_date')->nullable();
            $table->string('approver2_msg')->nullable();
            $table->integer('approver3')->nullable();
            $table->string('approver3_date')->nullable();
            $table->string('approver3_msg')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_expenses');
    }
}