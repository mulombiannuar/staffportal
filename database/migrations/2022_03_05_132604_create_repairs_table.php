<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id('repair_id');
            $table->integer('product_id');
            $table->integer('asset_id');
            $table->text('asset_issue');
            $table->text('action_done');
            $table->integer('action_by');
            $table->integer('current_user');
            $table->string('cost');
            $table->string('date_done');
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
        Schema::dropIfExists('repairs');
    }
}