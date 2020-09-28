<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCafoaFMSCafoasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_cafoa', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id');
            $table->string('number')->nullable();
            $table->string('payee');
            $table->integer('requesting_id');
            $table->json('lists');
            $table->json('signatories');
            $table->json('ledger')->nullable();
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
        Schema::dropIfExists('fms_form_cafoa');
    }
}
