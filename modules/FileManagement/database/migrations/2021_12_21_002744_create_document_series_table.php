<?php

use Illuminate\Support\Facades\Schema;
use Modules\System\core\Models\Office;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\core\Enums\Document\Status;
use Modules\FileManagement\core\Models\Document\Series;
use Modules\HumanResource\core\Models\Employee\Employee;

class CreateDocumentSeriesTable extends Migration
{
    public $table;

    public function __construct()
    {
        $this->table = (new Series())->getTable();
    }

    public function up()
    {
        $tables = [
            'office'   => (new Office())->getTable(),
            'employee' => (new Employee())->getTable(),
        ];

        Schema::create($this->table, function (Blueprint $table) use ($tables) {
            $table->id();

            $table->foreignId('office_id')->nullable()->constrained($tables['office'])->onDelete('set null');
            $table->foreignId('liaison_id')->nullable()->constrained($tables['employee'])->onDelete('set null');
            $table->foreignId('encoder_id')->nullable()->constrained($tables['employee'])->onDelete('set null');

            $table->enum('status', Status::lists())->default(Status::ACTIVATION->value);

            $table->integer('type');

            $table->json('properties')->nullable();

            $table->softDeletes('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
