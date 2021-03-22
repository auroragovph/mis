<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FmsFormCafoaCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_cafoa', function (Blueprint $table) {
            $table->id();

            $table->foreignId('document_id')->nullable()->constrained('fms_documents')->onDelete('set null');

            $table->foreignId('requesting_id')->nullable()->constrained('hrm_employees')->onDelete('set null');
            $table->foreignId('budget_id')->nullable()->constrained('hrm_employees')->onDelete('set null');
            $table->foreignId('treasury_id')->nullable()->constrained('hrm_employees')->onDelete('set null');
            $table->foreignId('accountant_id')->nullable()->constrained('hrm_employees')->onDelete('set null');

            $table->string('number')->nullable();
            $table->string('payee')->nullable();

            $table->json('lists')->nullable()->default(null);
            $table->json('ledger')->nullable()->default(null);
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
        Schema::dropIfExists('fms_form_cafoa');
    }
}
