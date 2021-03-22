<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SysActivityLogsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_activity_logs', function (Blueprint $table) {
            $table->id();
            $table->string('name')->default('sys');
            $table->string('log')->nullable();
            $table->foreignId('employee_id')->constrained('hrm_employees')->onDelete('cascade');
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
        Schema::dropIfExists('sys_activity_logs');
    }
}
