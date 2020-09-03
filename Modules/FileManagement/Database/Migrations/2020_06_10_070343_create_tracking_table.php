<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTrackingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fms_tracking', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('document_id');
            $table->integer('action');
            $table->text('purpose');
            $table->string('status');
            $table->integer('division_id');
            $table->integer('user_id');
            $table->integer('liaison_id');
            $table->softDeletes();
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
        Schema::dropIfExists('fms_tracking');
    }
}
