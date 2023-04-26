<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMaxStayHoursToCrmWorkflows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crm_workflows', function (Blueprint $table) {
            $table->string('max_stay_hours')->default(48);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crm_workflows', function (Blueprint $table) {
            $table->dropColumn('max_stay_hours');
        });
    }
}
