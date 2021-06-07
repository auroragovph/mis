<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\FileManagement\Entities\Procurement\PurchaseRequest;

class FmsFormPurchaseRequestAddParticularsColumn extends Migration
{

    private $table;

    public function __construct()
    {
        $this->table = (new PurchaseRequest())->getTable();
    }

    #Run the migrations
    public function up() : void
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->text('particulars')->after('purpose');
        });
    }

    #Reverse the migration
    public function down() : void
    {
        Schema::table($this->table, function (Blueprint $table) {
            $table->dropColumn('particulars');
        });
    }
}
