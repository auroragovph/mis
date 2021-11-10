<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\Entities\AFL\Leave;
use Modules\FileManagement\Entities\Document\Form;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\FileManagement\Entities\Document\Document;

class FmsFormAflCreateTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new Leave())->getTable();
    }

    public function up()
    {
        $tables = [
            'document' => (new Document())->getTable(),
            'employee' => (new Employee())->getTable()
        ];

        Schema::create($this->table, function (Blueprint $table) use($tables) {
            $table->id();

            $table->foreignId('document_id')->nullable()->constrained($tables['document'])->onDelete('set null');
            $table->foreignId('employee_id')->nullable()->constrained($tables['employee'])->onDelete('set null');

            $table->string('circular')->default(2020);

            $table->json('credits');
            $table->json('inclusives');

            $table->json('signatories');

            $table->json('properties')->nullable()->default(null);
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
