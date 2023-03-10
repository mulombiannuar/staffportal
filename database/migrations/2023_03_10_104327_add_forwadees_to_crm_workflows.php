<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForwadeesToCrmWorkflows extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crm_workflows', function (Blueprint $table) {
            $table->string('forwarded_to');
            $table->string('reverted_to');
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
            $table->dropColumn('forwarded_to');
            $table->dropColumn('reverted_to');
        });
    }
}
