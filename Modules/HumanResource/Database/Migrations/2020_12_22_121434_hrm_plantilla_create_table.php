<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HrmPlantillaCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_plantilla', function (Blueprint $table) {
            $table->id();
            $table->string('position', 255);
            $table->foreignId('salary_grade_id')->nullable()->constrained('hrm_salary_grade')->onDelete('set null');
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
        Schema::dropIfExists('hrm_plantilla');
    }
}
