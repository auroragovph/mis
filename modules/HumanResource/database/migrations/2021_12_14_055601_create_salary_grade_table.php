<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\HumanResource\core\Models\Plantilla\SalaryGrade;

class CreateSalaryGradeTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new SalaryGrade())->getTable();
    }

    public function up()
    {

        Schema::create($this->table, function (Blueprint $table)  {
            $table->id();

            $table->string('step1')->nullable();
            $table->string('step2')->nullable();
            $table->string('step3')->nullable();
            $table->string('step4')->nullable();
            $table->string('step5')->nullable();
            $table->string('step6')->nullable();
            $table->string('step7')->nullable();
            $table->string('step8')->nullable();

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
        Schema::dropIfExists($this->table);
    }
}
