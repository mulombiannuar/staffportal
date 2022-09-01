<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerCampaignsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_campaigns', function (Blueprint $table) {
            $table->id('campaign_id');
            $table->string('campaign_name');
            $table->string('start_date');
            $table->string('end_date');
            $table->string('target_areas');
            $table->string('target_products');
            $table->integer('created_by');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('customer_campaigns');
    }
}