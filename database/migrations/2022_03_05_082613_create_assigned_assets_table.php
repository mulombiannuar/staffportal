<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssignedAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assigned_assets', function (Blueprint $table) {
            $table->id('assigned_id');
            $table->integer('product_id');
            $table->integer('asset_id');
            $table->integer('previous_user');
            $table->integer('current_user');
            $table->integer('assigned_by');
            $table->string('date_assigned');
            $table->text('message');
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
        Schema::dropIfExists('assigned_assets');
    }
}