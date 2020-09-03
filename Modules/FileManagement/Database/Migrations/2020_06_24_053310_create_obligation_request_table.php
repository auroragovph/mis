<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObligationRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_obr', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_id');
            $table->string('number')->nullable();
            $table->text('payee');
            $table->text('address');
            $table->integer('dh_id');
            $table->integer('bo_id');
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
        Schema::dropIfExists('fms_form_obr');
    }
}
