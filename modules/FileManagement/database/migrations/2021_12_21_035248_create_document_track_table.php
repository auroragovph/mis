<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\System\core\Models\Office;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\core\Enums\Document\Status;
use Modules\FileManagement\core\Models\Document\Track;
use Modules\FileManagement\core\Models\Document\Series;
use Modules\HumanResource\core\Models\Employee\Employee;

class CreateDocumentTrackTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new Track())->getTable();
    }

    public function up()
    {
        $tables = [
            'office' => (new Office())->getTable(),
            'series' => (new Series())->getTable(),
            'employee' => (new Employee())->getTable(),
        ];

        Schema::create($this->table, function (Blueprint $table) use ($tables) {
            $table->id();

            $table->foreignId('series_id')->nullable()->constrained($tables['series'])->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained($tables['employee'])->onDelete('set null');
            $table->foreignId('liaison_id')->nullable()->constrained($tables['employee'])->onDelete('set null');
            $table->foreignId('office_id')->nullable()->constrained($tables['office'])->onDelete('set null');

            $table->enum('action', ['RECEIVE', 'RELEASE']);
            $table->text('purpose');
            $table->enum('status', Status::lists())->default(Status::ACTIVATION->value);

            $table->json('properties')->nullable();

            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
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
