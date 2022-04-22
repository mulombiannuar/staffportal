<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaintenanceLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maintenance_logs', function (Blueprint $table) {
            $table->id('log_id');
            $table->integer('product_id');
            $table->integer('asset_id');
            $table->integer('current_user');
            $table->string('date_done');
            $table->integer('action_by');
            $table->string('cost');
            $table->text('hdw_log_status');
            $table->text('hdw_log_comment');
            $table->text('hdd_cleanup_status');
            $table->text('hdd_cleanup_comment');
            $table->text('hdd_capacity_status');
            $table->text('hdd_capacity_comment');
            $table->text('hdw_tools_status');
            $table->text('hdw_tools_comment');
            $table->text('windows_update_status');
            $table->text('windows_update_comment');
            $table->text('browser_status');
            $table->text('browser_comment');
            $table->text('sftw_status');
            $table->text('sftw_comment');
            $table->text('antivirus_status');
            $table->text('antivirus_comment');
            $table->text('antivirus_log');
            $table->text('antivirus_log_comment');
            $table->text('security_log');
            $table->text('security_log_comment');
            $table->text('backup_status');
            $table->text('backup_comment');
            $table->text('supervisor_comment')->nullable();
            $table->text('manager_comment')->nullable();
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
        Schema::dropIfExists('maintenance_logs');
    }
}