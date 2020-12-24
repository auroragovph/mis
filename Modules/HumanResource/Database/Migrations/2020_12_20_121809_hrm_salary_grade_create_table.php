<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HrmSalaryGradeCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_salary_grade', function (Blueprint $table) {
            $table->id();

            $table->string('step1', 255)->nullable();
            $table->string('step2', 255)->nullable();
            $table->string('step3', 255)->nullable();
            $table->string('step4', 255)->nullable();
            $table->string('step5', 255)->nullable();
            $table->string('step6', 255)->nullable();
            $table->string('step7', 255)->nullable();
            $table->string('step8', 255)->nullable();

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
        Schema::dropIfExists('hrm_salary_grade');
    }
}
