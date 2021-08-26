<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\Entities\Document\Document;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\System\Entities\Office\Division;

class FmsDocumentsCreateTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new Document())->getTable();
    }

    public function up()
    {

        $tables = [
            'division' => (new Division())->getTable(),
            'employee' => (new Employee())->getTable()
        ];

        Schema::create($this->table, function (Blueprint $table) use($tables) {
            $table->id();

            $table->foreignId('division_id')->nullable()->constrained($tables['division'])->onDelete('set null');
            $table->foreignId('liaison_id')->nullable()->constrained($tables['employee'])->onDelete('set null');
            $table->foreignId('encoder_id')->nullable()->constrained($tables['employee'])->onDelete('set null');


            $table->tinyInteger('status')->default(1);
            $table->integer('type');

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
