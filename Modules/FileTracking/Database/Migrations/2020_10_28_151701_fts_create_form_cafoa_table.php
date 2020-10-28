<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FtsCreateFormCafoaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fts_form_cafoa', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('document_id');

            $table->string('number')->nullable();
            $table->string('payee');
            $table->string('amount');
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
        //
        Schema::dropIfExists('fts_form_cafoa');

    }
}
