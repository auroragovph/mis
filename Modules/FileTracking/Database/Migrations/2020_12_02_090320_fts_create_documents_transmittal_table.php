<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FtsCreateDocumentsTransmittalTable extends Migration
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
            $table->json('office')->default(json_encode(['receiving' => 0, 'releasing' => 0]));
            $table->json('employee')->default(json_encode(['receiving' => 0, 'releasing' => 0]));
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
