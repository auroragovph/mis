<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Modules\System\core\Models\ACL\Account;
use Illuminate\Database\Migrations\Migration;
use Modules\HumanResource\core\Models\Employee\Employee;

class CreateAccountTable extends Migration
{
    protected $table;

    public function __construct()
    {
        $this->table = (new Account())->getTable();
    }

    public function up()
    {
        $employee_table = (new Employee())->getTable();

        Schema::create($this->table, function (Blueprint $table) use($employee_table) {
            $table->id();

            $table->foreignId('employee_id')->nullable()->constrained($employee_table)->onDelete('set null');

            $table->string('username')->unique();
            $table->string('password');
            $table->boolean('status')->default(false);
            $table->json('properties')->nullable();
            $table->rememberToken();
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
