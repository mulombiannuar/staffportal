<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStartTimeToGroupVisitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('group_visitations', function (Blueprint $table) {
            $table->string('journey_from');
            $table->string('start_time');
            $table->string('end_time');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('group_visitations', function (Blueprint $table) {
            $table->dropColumn('journey_from');
            $table->dropColumn('start_time');
            $table->dropColumn('end_time');
        });
    }
}