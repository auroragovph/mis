<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FtsCreateFormItineraryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fts_form_travel_itinerary', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('document_id');

            $table->string('name');
            $table->string('position');
            $table->string('destination');
            $table->string('amount');
            $table->text('purpose');

            
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
        Schema::dropIfExists('fts_form_travel_itinerary');
        
    }
}
