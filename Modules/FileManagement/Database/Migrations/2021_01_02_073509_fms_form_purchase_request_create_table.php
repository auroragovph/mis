<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FmsFormPurchaseRequestCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_purchase_request', function (Blueprint $table) {
            $table->id();

            $table->foreignId('document_id')->nullable()->constrained('fms_documents')->onDelete('set null');

            $table->foreignId('requesting_id')->nullable()->constrained('hrm_employees')->onDelete('set null');
            $table->foreignId('treasury_id')->nullable()->constrained('hrm_employees')->onDelete('set null');
            $table->foreignId('approving_id')->nullable()->constrained('hrm_employees')->onDelete('set null');

            $table->string('number')->nullable();
            $table->string('fund')->nullable();
            $table->string('fpp')->nullable();
            $table->text('purpose')->nullable();

            $table->json('lists')->nullable()->default(null);
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
        Schema::dropIfExists('fms_form_purchase_request');
        
    }
}
