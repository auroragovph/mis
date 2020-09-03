<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentAttachTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_documents_attachment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_id');
            $table->text('description');
            $table->text('url')->nullable();
            $table->string('mime');
            $table->integer('employee_id');
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
        Schema::dropIfExists('fms_documents_attachment');
    }
}
