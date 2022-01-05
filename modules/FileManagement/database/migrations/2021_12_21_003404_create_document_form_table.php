<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\core\Models\Document\Form;
use Modules\FileManagement\core\Models\Document\Series;
use Modules\HumanResource\core\Models\Employee\Employee;

class CreateDocumentFormTable extends Migration
{
    public string $table;

    public function __construct()
    {
        $this->table = (new Form())->getTable();
    }

    public function up()
    {
        $tables = [
            'series' => (new Series())->getTable(),
            'employee' => (new Employee())->getTable()
        ];

        Schema::create($this->table, function (Blueprint $table) use($tables) {
            $table->id();
            $table->foreignId('series_id')->nullable()->constrained($tables['series'])->onDelete('set null');
            $table->morphs('formable');

            $table->foreignId('encoder_id')->nullable()->constrained($tables['employee'])->onDelete('set null');

            $table->json('properties')->nullable()->default(null);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
