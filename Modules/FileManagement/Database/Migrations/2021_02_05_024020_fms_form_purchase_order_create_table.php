<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\Entities\Procurement\FMS_PO;

class FmsFormPurchaseOrderCreateTable extends Migration
{    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_purchase_order', function (Blueprint $table) {
            $table->id();

            $table->foreignId('document_id')->nullable()->constrained('fms_documents')->onDelete('set null');
            $table->foreignId('approving_id')->nullable()->constrained('hrm_employees')->onDelete('set null');

            $table->string('number')->nullable();
            $table->string('mode_of_procurement')->nullable();
            $table->json('supplier')->nullable();
            $table->json('delivery')->nullable();
            $table->json('pr_number')->nullable();
            
            $table->text('particulars')->nullable();

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
        Schema::dropIfExists('fms_form_purchase_order');
    }
}
