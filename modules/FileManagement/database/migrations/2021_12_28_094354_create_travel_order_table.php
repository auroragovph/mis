<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\core\Models\Document\Series;
use Modules\FileManagement\core\Models\Travel\Order;
use Modules\System\core\Models\Office;

class CreateTravelOrderTable extends Migration
{
    public string $table;

    public function __construct()
    {
        $this->table = (new Order())->getTable();
    }

    public function up()
    {
        $tables = [
            'series' => (new Series())->getTable(),
            'office' => (new Office())->getTable()
        ];


        Schema::create($this->table, function (Blueprint $table) use($tables) {
            $table->id();

            $table->foreignId('series_id')->nullable()->constrained($tables['series'])->onDelete('set null');
            $table->foreignId('charging_id')->nullable()->constrained($tables['office'])->onDelete('set null');

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


    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
