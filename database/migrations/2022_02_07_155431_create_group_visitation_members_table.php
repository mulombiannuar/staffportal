<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGroupVisitationMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('group_visitation_members', function (Blueprint $table) {
            $table->id('member_id');
            $table->integer('visit_id');
            $table->integer('activity_type');
            $table->string('client_phone');
            $table->string('client_name');
            $table->string('client_id');
            $table->string('group_code');
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
        Schema::dropIfExists('group_visitation_members');
    }
}