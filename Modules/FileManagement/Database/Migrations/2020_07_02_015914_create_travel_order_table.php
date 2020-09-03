<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_travel_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_id');
            $table->string('number')->nullable();
            $table->text('destination');
            $table->date('departure');
            $table->date('arrival');
            $table->text('purpose');
            $table->text('instruction')->nullable();
            $table->integer('approval_id');
            $table->integer('charging_id');
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
        Schema::dropIfExists('fms_form_travel_order');
    }
}
