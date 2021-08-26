<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\System\Entities\Office\Division;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\Entities\Document\Track;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\FileManagement\Entities\Document\Document;

class FmsDocumentsTrackingCreateTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new Track())->getTable();
    }

    public function up()
    {
        $tables = [
            'division' => (new Division())->getTable(),
            'document' => (new Document())->getTable(),
            'employee' => (new Employee())->getTable()
        ];

        Schema::create($this->table, function (Blueprint $table) use($tables) {
            $table->id();

            $table->foreignId('document_id')->nullable()->constrained($tables['document'])->onDelete('set null');
            $table->foreignId('user_id')->nullable()->constrained($tables['employee'])->onDelete('set null');
            $table->foreignId('liaison_id')->nullable()->constrained($tables['employee'])->onDelete('set null');
            $table->foreignId('division_id')->nullable()->constrained($tables['division'])->onDelete('set null');

            $table->integer('action');
            $table->text('purpose');
            $table->string('status');

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
