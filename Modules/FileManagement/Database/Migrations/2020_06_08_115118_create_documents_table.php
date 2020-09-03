<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_documents', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('division_id');
            $table->integer('liaison_id');
            $table->integer('encoder_id');
            $table->string('status', 2)->default('1');
            $table->integer('type');
            $table->softDeletes();
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
        Schema::dropIfExists('fms_documents');
    }
}
