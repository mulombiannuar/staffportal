<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddApprovalStatusToUserExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_expenses', function (Blueprint $table) {
            $table->integer('approver1_status')->nullable();
            $table->integer('approver2_status')->nullable();
            $table->integer('approver3_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_expenses', function (Blueprint $table) {
            $table->dropColumn('approver1_status');
            $table->dropColumn('approver2_status');
            $table->dropColumn('approver3_status');
        });
    }
}