<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\System\core\Models\ActivityLog;
use Illuminate\Database\Migrations\Migration;
use Modules\HumanResource\core\Models\Employee\Employee;

class CreateActivityLog extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new ActivityLog())->getTable();
    }

    public function up()
    {
        $employee_table = (new Employee())->getTable();

        Schema::create($this->table, function (Blueprint $table) use ($employee_table) {
            $table->id();
            $table->string('name')->default('sys');
            $table->string('log')->nullable();
            $table->foreignId('employee_id')->constrained($employee_table)->onDelete('cascade');
            $table->json('agent')->nullable()->default(null);
            $table->json('properties')->nullable()->default(null);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
