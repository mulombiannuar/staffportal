<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id('profile_id');
            $table->integer('user_id');
            $table->string('gender');
            $table->string('birth_date');
            $table->integer('county');
            $table->integer('sub_county');
            $table->integer('branch');
            $table->integer('outpost');
            $table->string('mobile_no');
            $table->string('religion');
            $table->string('address');
            $table->string('user_image')->default('avatar.png');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}