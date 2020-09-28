<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFMSAFLsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_afl', function (Blueprint $table) {
            $table->id();
            $table->integer('employee_id');
            $table->json('properties');
            $table->json('credits');
            $table->json('inclusives');
            $table->json('signatories');
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
        Schema::dropIfExists('fms_form_afl');
    }
}
