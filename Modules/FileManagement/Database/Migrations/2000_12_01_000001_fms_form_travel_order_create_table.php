<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\System\Entities\Office\Division;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Travel\TravelOrder;

class FmsFormTravelOrderCreateTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new TravelOrder())->getTable();
    }

    public function up()
    {
        $tables = [
            'document' => (new Document())->getTable(),
            'division' => (new Division())->getTable()
        ];


        Schema::create($this->table, function (Blueprint $table) use($tables) {
            $table->id();

            $table->foreignId('document_id')->nullable()->constrained($tables['document'])->onDelete('set null');
            $table->foreignId('charging_id')->nullable()->constrained($tables['division'])->onDelete('set null');

            $table->string('number')->nullable();
            $table->text('destination');
            $table->date('departure');
            $table->date('arrival');
            $table->text('purpose');
            $table->text('instruction')->nullable();

            $table->json('employees');
            $table->json('signatories');
            
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
