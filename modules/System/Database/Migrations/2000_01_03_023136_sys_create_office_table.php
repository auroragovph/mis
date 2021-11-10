<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\System\Entities\Office\Office;
use Illuminate\Database\Migrations\Migration;
use Modules\HumanResource\Entities\Employee\Employee;

class SysCreateOfficeTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new Office())->getTable();
    }


    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {

            $table->id();
            $table->string('name', 255);
            $table->string('alias', 255)->nullable();


            $table->json('properties')->nullable();
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
        Schema::dropIfExists($this->table);
    }
}
