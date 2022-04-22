<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMotorMaintenancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('motor_maintenances', function (Blueprint $table) {
            $table->id('log_id');
            $table->integer('user_id');
            $table->integer('asset_id');
            $table->string('reference');
            $table->string('type');
            $table->string('date');
            $table->integer('status')->default(0);
            $table->text('message');
            $table->integer('approved_by')->nullable();
            $table->text('approval_message')->nullable();;
            $table->string('service_date')->nullable();
            $table->text('service_done')->nullable();
            $table->integer('service_by')->nullable();
            $table->string('service_cost')->nullable();
            $table->string('service_cause')->nullable();
            $table->text('additional_info')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('motor_maintenances');
    }
}