<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Procurement\Air;
use Modules\FileManagement\Entities\Procurement\PurchaseOrder;

class FmsFormAirCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create((new Air())->getTable(), function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->nullable()->constrained((new Document())->getTable())->onDelete('set null');
            $table->foreignId('po_id')->nullable()->constrained((new PurchaseOrder)->getTable())->onDelete('set null');

            $table->string('number');
            $table->json('invoice');

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
