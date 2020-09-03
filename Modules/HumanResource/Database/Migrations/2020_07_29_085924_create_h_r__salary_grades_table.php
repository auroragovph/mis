<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHRSalaryGradesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_salary_grade', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('step1', 255);
            $table->string('step2', 255);
            $table->string('step3', 255);
            $table->string('step4', 255);
            $table->string('step5', 255);
            $table->string('step6', 255);
            $table->string('step7', 255);
            $table->string('step8', 255);
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
        Schema::dropIfExists('hrm_salary_grade');
    }
}
