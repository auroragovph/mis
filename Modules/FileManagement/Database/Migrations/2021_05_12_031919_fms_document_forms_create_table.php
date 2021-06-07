<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FmsDocumentFormsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_documents_form', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->nullable()->constrained('fms_documents')->onDelete('set null');
            $table->morphs('formable');
            $table->json('properties')->nullable()->default(null);
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
        Schema::dropIfExists('fms_documents_form');
    }
}
