<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\core\Models\Document\Series;
use Modules\HumanResource\core\Models\Employee\Employee;
use Modules\FileManagement\core\Models\Document\Attachment;

class CreateDocumentAttachmentTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new Attachment())->getTable();
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
            $table->foreignId('employee_id')->nullable()->constrained($tables['employee'])->onDelete('set null');

            $table->tinyInteger('status')->default(1);

            $table->text('description')->nullable()->default(null);

            $table->string('url')->nullable()->default(null);
            $table->string('mime')->nullable()->default(null);

            $table->json('properties')->nullable();

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
