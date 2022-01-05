<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\core\Models\Procurement\PPMP;

class CreateProcurementPpmpTable extends Migration
{
    public string $table;

    public function __construct()
    {
        $this->table = (new PPMP())->getTable();
    }
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->id();

            $table->foreignId('office_id')->nullable()->constrained((new \Modules\System\core\Models\Office())->getTable())->onDelete('set null');
            $table->integer('fiscal_year')->nullable();

            $table->string('code')->nullable();
            $table->string('description')->nullable();
            $table->string('unit')->nullable();
            $table->float('unit_cost')->nullable();
            $table->string('mop')->nullable();
            $table->json('schedule')->nullable();

            $table->nestedSet();
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
