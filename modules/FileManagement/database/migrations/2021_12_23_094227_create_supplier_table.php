<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\core\Models\Procurement\Supplier;

class CreateSupplierTable extends Migration
{
    public string $table;

    public function __construct()
    {
        $this->table = (new Supplier())->getTable();
    }

    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('owner');
            $table->string('address');
            $table->string('tin');

            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
