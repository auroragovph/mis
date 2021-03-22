<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FmsDocumentsTrackingCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_documents_tracking', function (Blueprint $table) {
            $table->id();

            $table->foreignId('document_id')->nullable()->constrained('fms_documents')->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained('hrm_employees')->onDelete('set null');
            $table->foreignId('liaison_id')->nullable()->constrained('hrm_employees')->onDelete('set null');
            $table->foreignId('division_id')->nullable()->constrained('sys_division')->onDelete('set null');

            $table->integer('action');
            $table->text('purpose');
            $table->string('status');

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
        Schema::dropIfExists('fms_documents_tracking');
    }
}
