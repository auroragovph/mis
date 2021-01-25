<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FtsDocumentsTransmittalCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fts_documents_transmittal', function (Blueprint $table) {

            $table->uuid('id')->primary();

            $table->integer('receiving_office');
            $table->integer('receiving_employee')->nullable();
            $table->integer('releasing_office');
            $table->integer('releasing_employee');

            $table->json('documents');

            
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
        Schema::dropIfExists('fts_documents_transmittal');
        
    }
}
