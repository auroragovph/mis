<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FmsFormTravelOrderCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_travel_order', function (Blueprint $table) {
            $table->id();

            $table->foreignId('document_id')->nullable()->constrained('fms_documents')->onDelete('set null');
            $table->foreignId('approval_id')->nullable()->constrained('hrm_employees')->onDelete('set null');
            $table->foreignId('charging_id')->nullable()->constrained('sys_division')->onDelete('set null');

            $table->string('number')->nullable();
            $table->text('destination');
            $table->date('departure');
            $table->date('arrival');
            $table->text('purpose');
            $table->text('instruction')->nullable();
            
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
        Schema::dropIfExists('fms_form_travel_order');
        
    }
}
