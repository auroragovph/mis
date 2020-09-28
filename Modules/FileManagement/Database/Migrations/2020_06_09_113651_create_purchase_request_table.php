<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchaseRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_purchase_request', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('document_id');
            $table->string('number')->nullable();
            $table->string('fpp')->nullable();
            $table->string('fund')->nullable();
            $table->text('purpose');
            $table->json('signatories');
            $table->json('lists');
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
