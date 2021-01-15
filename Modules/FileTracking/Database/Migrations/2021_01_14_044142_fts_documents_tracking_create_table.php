<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FtsDocumentsTrackingCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fts_documents_tracking', function (Blueprint $table) {
            $table->id();

            $table->integer('document_id');

            $table->integer('division_id');
            $table->integer('user_id');
            $table->integer('liaison_id');

            $table->integer('action');
            $table->text('purpose');
            $table->string('status');


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
        Schema::dropIfExists('fts_documents_tracking');
    }
}
