<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\core\Models\Document\Series;
use Modules\FileManagement\core\Models\Procurement\Supplier;
use Modules\FileManagement\core\Models\Procurement\PurchaseOrder;

class CreateProcurementOrderTable extends Migration
{
    public string $table;

    public function __construct()
    {
        $this->table = (new PurchaseOrder())->getTable();
    }

    public function up()
    {
        $tables = [
            'series' => (new Series())->getTable(),
        ];

        Schema::create($this->table, function (Blueprint $table) use($tables) {
            $table->id();

            $table->foreignId('series_id')->nullable()->constrained($tables['series'])->onDelete('set null');

            $table->string('circular')->default(2022);

            $table->string('number')->nullable();
            $table->string('mode_of_procurement')->nullable();


            $table->json('delivery')->nullable();
            $table->json('pr_number')->nullable();
            $table->json('supplier')->nullable();

            $table->text('particulars')->nullable();

            $table->json('lists')->nullable()->default(null);

            $table->json('signatories')->nullable()->default(null);
            $table->json('properties')->nullable()->default(null);
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
