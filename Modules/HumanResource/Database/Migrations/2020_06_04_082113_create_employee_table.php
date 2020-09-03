<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmployeeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hrm_employee', function (Blueprint $table) {
            $table->id();

            $table->integer('division_id')->unsigned();
            $table->integer('position_id')->unsigned();

            $table->json('name');
            $table->json('info');
            $table->json('employement');

            $table->string('card', 255);
            $table->boolean('liaison');

            $table->softDeletes('deleted_at', 0);
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
        Schema::dropIfExists('hrm_employee');
    }
}
