<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FmsFormTravelOrderListsCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_form_travel_order_lists', function (Blueprint $table) {
            $table->foreignId('form_id')->nullable()->constrained('fms_documents')->onDelete('set null');
            $table->foreignId('employee_id')->nullable()->constrained('hrm_employees')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fms_form_travel_order_lists');
    }
}
