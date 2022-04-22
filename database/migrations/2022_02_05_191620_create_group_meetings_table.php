<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupMeetingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_meetings', function (Blueprint $table) {
            $table->id('meeting_id');
            $table->string('group_code');
            $table->string('group_name');
            $table->string('officer');
            $table->string('frequency');
            $table->integer('created_by');
            $table->integer('outpost_id');
            $table->string('day');
            $table->string('starting_time');
            $table->string('ending_time');
            $table->string('place');
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
        Schema::dropIfExists('group_meetings');
    }
}