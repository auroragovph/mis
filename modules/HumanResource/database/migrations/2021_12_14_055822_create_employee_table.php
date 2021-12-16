<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\HumanResource\core\Models\Employee\Employee;
use Modules\HumanResource\core\Models\Plantilla\Position;
use Modules\System\core\Models\Office;

class CreateEmployeeTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new Employee())->getTable();
    }

    public function up()
    {
        $position_table = (new Position())->getTable();
        $office_table = (new Office())->getTable();

        Schema::create($this->table, function (Blueprint $table) use($position_table, $office_table) {

            $table->id();

            $table->foreignId('position_id')->nullable()->constrained($position_table)->onDelete('set null');
            $table->foreignId('office_id')->nullable()->constrained($office_table)->onDelete('set null');

            $table->json('name')->nullable();
            $table->json('info')->nullable();
            $table->json('employment')->nullable();

            $table->string('card')->nullable();
            $table->boolean('liaison');


            $table->json('properties')->nullable();

            $table->softDeletes('deleted_at')->nullable();
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
