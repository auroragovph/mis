<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\System\Entities\ActivityLog;

class SysActivityLogsCreateTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new ActivityLog())->getTable();
    }

    public function up()
    {
        $employee_table = (new Employee())->getTable();

        Schema::create($this->table, function (Blueprint $table) use($employee_table) {
            $table->id();
            $table->string('name')->default('sys');
            $table->string('log')->nullable();
            $table->foreignId('employee_id')->constrained($employee_table)->onDelete('cascade');
            $table->json('agent')->nullable()->default(null);
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
        Schema::dropIfExists($this->table);
    }
}
