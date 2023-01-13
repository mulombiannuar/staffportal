<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientChangeFormsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_change_forms', function (Blueprint $table) {
            $table->id('form_id');
            $table->integer('client_id');
            // $table->integer('filing_type_id');
            $table->integer('file_number');
            $table->string('date_changed');
            $table->string('file_name');
            $table->integer('created_by');
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
        Schema::dropIfExists('client_change_forms');
    }
}
