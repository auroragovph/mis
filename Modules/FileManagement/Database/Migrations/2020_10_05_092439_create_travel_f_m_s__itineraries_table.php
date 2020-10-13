<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTravelFMSItinerariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_travel_itinerary', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id');
            $table->integer('employee_id');
            $table->string('number')->nullable();
            $table->string('fund')->nullable();
            $table->json('properties');
            $table->json('lists');
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
        Schema::dropIfExists('fms_form_travel_itinerary');
    }
}
