<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FmsFormTravelItineraryCreateTable extends Migration
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

            $table->foreignId('document_id')->nullable()->constrained('fms_documents')->onDelete('set null');

            $table->foreignId('employee_id')->nullable()->constrained('hrm_employees')->onDelete('set null');

            $table->string('number')->nullable();
            $table->string('fund')->nullable();

            $table->text('travel_purpose')->nullable();
            $table->date('travel_date')->nullable();

            $table->foreignId('supervisor_id')->nullable()->constrained('hrm_employees')->onDelete('set null');
            $table->foreignId('head_id')->nullable()->constrained('hrm_employees')->onDelete('set null');


            $table->json('lists')->nullable()->default(null);
            $table->json('properties')->nullable()->default(null);
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
    }
}
