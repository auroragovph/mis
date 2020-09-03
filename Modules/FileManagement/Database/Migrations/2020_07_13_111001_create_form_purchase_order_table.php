<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFormPurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_purchase_order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('document_id');
            $table->string('number')->nullable();
            $table->string('mop');
            $table->date('date')->nullable();
            $table->json('supplier');
            $table->json('delivery');
            $table->json('lists');
            $table->integer('requesitioning_id');
            $table->integer('accounting_id');
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
