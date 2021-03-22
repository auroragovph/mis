<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HrmEmployeeUpdateForeignForDivision extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
          // SETTING UP FOREIGN RELATIONSHIPS
          Schema::table('hrm_employees', function (Blueprint $table) {
            $table->foreignId('division_id')->after('id')->nullable()->constrained('sys_division')->onDelete('set null');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
