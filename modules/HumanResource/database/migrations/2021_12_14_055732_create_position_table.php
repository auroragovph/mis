<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\HumanResource\core\Models\Plantilla\Position;
use Modules\HumanResource\core\Models\Plantilla\SalaryGrade;

class CreatePositionTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new Position())->getTable();
    }

    public function up()
    {
        $sg_table = (new SalaryGrade())->getTable();

        Schema::create($this->table, function (Blueprint $table) use($sg_table) {
            $table->id();
            $table->string('name', 255);
            $table->foreignId('salary_grade_id')->nullable()->constrained($sg_table)->onDelete('set null');
            $table->json('properties')->nullable();
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
