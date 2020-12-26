<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class SysDivisionCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_division', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->default('MAIN');
            $table->string('alias', 255)->nullable();
            $table->json('properties')->nullable();
            $table->boolean('status')->default(true);
            $table->foreignId('office_id')->nullable()->constrained('sys_office')->onDelete('set null');
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
        Schema::dropIfExists('sys_division');
    }
}
