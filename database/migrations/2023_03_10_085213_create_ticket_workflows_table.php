<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketWorkflowsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_workflows', function (Blueprint $table) {
            $table->id();
            $table->integer('ticket_id');
            $table->integer('workflow_id');
            $table->integer('is_current');
            $table->text('workflow_message');
            $table->integer('message_by');
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
        Schema::dropIfExists('ticket_workflows');
    }
}
