<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObligationRequestDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_obr_data', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('obr_id');
            $table->string('responsibility_center')->nullable();
            $table->text('particulars')->nullable();
            $table->string('fpp')->nullable();
            $table->string('account_code')->nullable();
            $table->string('amount')->nullable();
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
        Schema::dropIfExists('fms_form_obr_data');
    }
}
