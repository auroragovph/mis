<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FtsCreateFormAflTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fts_form_afl', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('document_id');

            $table->string('name');
            $table->string('position');
            $table->string('type');
            $table->date('credits');
            $table->json('inclusives');
            $table->json('leave');
            
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
        Schema::dropIfExists('fts_form_afl');
        
    }
}
