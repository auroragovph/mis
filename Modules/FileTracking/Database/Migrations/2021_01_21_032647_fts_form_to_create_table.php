<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FtsFormToCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fts_form_to', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('document_id');

            $table->string('number')->nullable();
            $table->date('date');
            $table->json('employees');
            $table->string('destination');
            $table->date('departure');
            $table->date('arrival');
            $table->text('particulars');
            
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
        Schema::dropIfExists('fts_form_to');
    }
}
