<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUploadedExcelDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('uploaded_excel_data', function (Blueprint $table) {
            $table->id();
            $table->string('disbursment_date');
            $table->string('records_affected');
            $table->string('upload_type');
            $table->string('uploaded_by');
            $table->string('excel_file_name');
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
        Schema::dropIfExists('uploaded_excel_data');
    }
}
