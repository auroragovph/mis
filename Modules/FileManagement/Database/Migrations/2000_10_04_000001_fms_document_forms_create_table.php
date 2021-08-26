<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\System\Entities\Office\Division;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\Entities\Document\Form;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\FileManagement\Entities\Document\Document;

class FmsDocumentFormsCreateTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new Form())->getTable();
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
            $table->morphs('formable');

            $table->foreignId('encoder_id')->nullable()->constrained($tables['employee'])->onDelete('set null');

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
