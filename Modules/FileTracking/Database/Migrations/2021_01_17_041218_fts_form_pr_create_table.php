<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FtsFormPrCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fts_form_pr', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('document_id');

            $table->string('number')->nullable();
            $table->date('date');
            $table->text('particulars');
            $table->text('purpose');
            $table->string('charging')->nullable();
            $table->string('accountable');
            $table->string('amount');
            
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
        Schema::dropIfExists('fts_form_pr');
        
    }
}
