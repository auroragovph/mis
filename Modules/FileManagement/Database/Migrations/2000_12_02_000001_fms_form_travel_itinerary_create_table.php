<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\Entities\Travel\Itinerary;
use Modules\HumanResource\Entities\Employee\Employee;
use Modules\FileManagement\Entities\Document\Document;

class FmsFormTravelItineraryCreateTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new Itinerary())->getTable();
    }

    public function up()
    {
        $tables = [
            'document' => (new Document())->getTable(),
            'employee' => (new Employee())->getTable(),
        ];

        Schema::create($this->table, function (Blueprint $table) use($tables) {
            $table->id();

            $table->foreignId('document_id')->nullable()->constrained($tables['document'])->onDelete('set null');
            $table->foreignId('employee_id')->nullable()->constrained($tables['employee'])->onDelete('set null');

            $table->string('circular')->default(2020);


            $table->string('number')->nullable();
            $table->string('fund')->nullable();
            $table->date('date')->nullable();


            $table->text('purpose')->nullable();
            $table->text('particulars')->nullable();

            $table->foreignId('supervisor_id')->nullable()->constrained($tables['employee'])->onDelete('set null');
            $table->foreignId('head_id')->nullable()->constrained($tables['employee'])->onDelete('set null');


            $table->json('lists')->nullable()->default(null);
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
