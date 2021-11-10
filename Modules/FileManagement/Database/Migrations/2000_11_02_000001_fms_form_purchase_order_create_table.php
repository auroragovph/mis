<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\AwardCommittee\Entities\Procurement\Supplier;
use Modules\FileManagement\Entities\Document\Document;
use Modules\FileManagement\Entities\Procurement\PurchaseOrder;

class FmsFormPurchaseOrderCreateTable extends Migration
{    
    protected $table;

    public function __construct()
    {
        $this->table = (new PurchaseOrder())->getTable();
    }

    public function up()
    {
        $tables = [
            'document' => (new Document())->getTable(),
            'supplier' => (new Supplier())->getTable(),
        ];

        Schema::create($this->table, function (Blueprint $table) use($tables) {
            $table->id();

            $table->foreignId('document_id')->nullable()->constrained($tables['document'])->onDelete('set null');
            $table->foreignId('supplier_id')->nullable()->constrained($tables['supplier'])->onDelete('set null');

            $table->string('circular')->default(2020);


            $table->string('number')->nullable();
            $table->string('mode_of_procurement')->nullable();
            

            $table->json('delivery')->nullable();
            $table->json('pr_number')->nullable();
            
            $table->text('particulars')->nullable();

            $table->json('lists')->nullable()->default(null);

            $table->json('signatories')->nullable()->default(null);
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
