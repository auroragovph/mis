<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FtsCreateDocumentsAttachmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fts_documents_attachment', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('document_id');
            $table->bigInteger('employee_id');

            $table->string('description');
            $table->json('properties')->nullable();

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
        Schema::dropIfExists('fts_documents_attachment');
    }
}
