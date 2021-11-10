<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\System\Entities\Office\Division;
use Modules\System\Entities\Office\Office;

class SysDivisionCreateTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new Division())->getTable();
    }

    public function up()
    {
        $office_table = (new Office())->getTable();

        Schema::create($this->table, function (Blueprint $table) use($office_table) {
            $table->id();
            $table->string('name')->default('MAIN');
            $table->string('alias')->nullable();
            $table->json('properties')->nullable();
            $table->boolean('status')->default(true);
            $table->foreignId('office_id')->nullable()->constrained($office_table)->onDelete('set null');
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
