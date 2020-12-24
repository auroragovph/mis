<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HrmEmployeeCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_employees', function (Blueprint $table) {
            $table->id();

            // I ADD THE DIVISION_ID CONSTRAINED IN SYS_DIVISION MIGRATION FILE
            
            $table->foreignId('position_id')->nullable()->constrained('hrm_plantilla')->onDelete('set null');

            $table->json('name')->nullable();
            $table->json('info')->nullable();
            $table->json('employment')->nullable();

            $table->string('card', 255);
            $table->boolean('liaison');


            $table->json('properties')->nullable();

            $table->softDeletes('deleted_at')->nullable();
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
        Schema::dropIfExists('hrm_employees');
    }
}
