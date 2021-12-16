<?php

use Illuminate\Support\Facades\Schema;
use Modules\System\core\Models\Office;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOfficesTable extends Migration
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
            $table->string('name');
            $table->string('alias');
            $table->boolean('is_visible')->default(true);
            $table->nestedSet();
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
