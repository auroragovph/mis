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
            $table->increments('id');
            $table->string('fname', 255);
            $table->string('lname', 255);
            $table->string('mname', 255);
            $table->tinyInteger('gender');
            $table->text('address');
            $table->date('birthday');
            $table->string('civil_status',255);
            $table->string('phone_number',255);
            $table->integer('division_id');
            $table->string('position', 255);
            $table->tinyInteger('employment_type');
            $table->boolean('employment_status');
            $table->string('id_no', 255);
            $table->boolean('liaison');
            $table->timestamps();
            $table->softDeletes('deleted_at', 0);
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
