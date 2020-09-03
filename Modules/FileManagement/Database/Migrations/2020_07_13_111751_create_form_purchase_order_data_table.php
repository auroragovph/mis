<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormPurchaseOrderDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_purchase_order_data', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('po_id');
            $table->string('stock')->nullable();
            $table->string('unit')->nullable();
            $table->text('description');
            $table->string('qty');
            $table->string('cost');
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
        Schema::dropIfExists('fms_form_purchase_order_data');
    }
}
