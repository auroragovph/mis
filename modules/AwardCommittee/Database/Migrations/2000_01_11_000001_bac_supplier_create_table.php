<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\AwardCommittee\Entities\Procurement\Supplier;

class BacSupplierCreateTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new Supplier())->getTable();
    }

    public function up()
    {
        $tables = [];

        Schema::create($this->table, function (Blueprint $table) use($tables) {
            $table->id();

            $table->string('name');
            $table->string('owner');
            $table->string('address');
            $table->string('tin');

            $table->json('properties')->nullable();
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
