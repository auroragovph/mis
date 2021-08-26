<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\System\Entities\Office\Office;
use Illuminate\Database\Migrations\Migration;
use Modules\HumanResource\Entities\Employee\Employee;

class SysOfficeAddDhId extends Migration
{
    
    protected $table;

    public function __construct()
    {
        $this->table = (new Office())->getTable();
    }

    public function up()
    {
        $employee_table = (new Employee())->getTable();

        Schema::table($this->table, function(Blueprint $table) use ($employee_table){
            $table->foreignId('head_id')->after('alias')->nullable()->constrained($employee_table)->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $class = $this;

        Schema::table($this->table, function(Blueprint $table) use($class){
            $column_name = 'head_id';
            $foreign_name = $class->table."_".$column_name."_foreign";
            
            $table->dropForeign($foreign_name);
            $table->dropColumn($column_name);
        });

    }
}
