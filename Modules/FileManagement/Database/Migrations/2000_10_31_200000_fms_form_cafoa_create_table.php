<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\Entities\Cafoa\Cafoa;
use Modules\FileManagement\Entities\Document\Document;

class FmsFormCafoaCreateTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new Cafoa())->getTable();
    }

    public function up()
    {
        $tables = [
            'document' => (new Document())->getTable()
        ];


        Schema::create($this->table, function (Blueprint $table) use($tables) {
            $table->id();

            $table->foreignId('document_id')->nullable()->constrained($tables['document'])->onDelete('set null');

            $table->integer('circular')->default(2020);


            $table->string('number')->nullable();
            $table->string('payee')->nullable();

            $table->json('signatories')->nullable()->default(null);

            $table->json('lists')->nullable()->default(null);
            $table->json('ledger')->nullable()->default(null);

            $table->text('particulars')->nullable();

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
        Schema::dropIfExists('fms_form_cafoa');
    }
}
