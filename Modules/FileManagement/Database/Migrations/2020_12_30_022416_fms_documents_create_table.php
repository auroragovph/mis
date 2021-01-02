<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FmsDocumentsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_documents', function (Blueprint $table) {
            $table->id();

            $table->foreignId('division_id')->nullable()->constrained('sys_division')->onDelete('set null');
            $table->foreignId('liaison_id')->nullable()->constrained('hrm_employees')->onDelete('set null');
            $table->foreignId('encoder_id')->nullable()->constrained('hrm_employees')->onDelete('set null');

            $table->string('status', 2)->default('1');
            $table->integer('type');

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
        Schema::dropIfExists('fms_documents');
        
    }
}
