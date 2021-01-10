<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FmsFormAflCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_afl', function (Blueprint $table) {
            $table->id();

            $table->foreignId('document_id')->nullable()->constrained('fms_documents')->onDelete('set null');
            $table->foreignId('employee_id')->nullable()->constrained('hrm_employees')->onDelete('set null');

            $table->foreignId('approval_id')->nullable()->constrained('hrm_employees')->onDelete('set null');
            $table->foreignId('hr_id')->nullable()->constrained('hrm_employees')->onDelete('set null');

            $table->json('credits');
            $table->json('inclusives');

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
        Schema::dropIfExists('fms_form_afl');
    }
}
