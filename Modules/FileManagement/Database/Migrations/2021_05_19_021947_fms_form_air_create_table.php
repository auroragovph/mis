<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\Entities\Document\FMS_Document as Document;
use Modules\FileManagement\Entities\Procurement\FMS_PO as PurchaseOrder;

class FmsFormAirCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_air', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->nullable()->constrained((new Document())->getTable())->onDelete('set null');
            $table->foreignId('po_id')->nullable()->constrained((new PurchaseOrder)->getTable())->onDelete('set null');

            $table->string('number');
            $table->string('invoice');
            $table->date('invoice_date');
            
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
        Schema::dropIfExists('fms_form_air');
    }
}
