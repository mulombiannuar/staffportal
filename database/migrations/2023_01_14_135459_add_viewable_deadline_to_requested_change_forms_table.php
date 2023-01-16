<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewableDeadlineToRequestedChangeFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('requested_change_forms', function (Blueprint $table) {
            $table->string('viewable_deadline')->nullable();
            $table->integer('is_locked')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('requested_change_forms', function (Blueprint $table) {
            $table->dropColumn('viewable_deadline');
            $table->dropColumn('is_locked');
        });
    }
}
