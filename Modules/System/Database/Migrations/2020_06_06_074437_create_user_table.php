<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\System\Entities\SYS_User;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_users', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->string('username', 255);
            $table->text('password');
            $table->boolean('status');
            $table->timestamp('last_login')->nullable();
            $table->softDeletes('deleted_at');
            $table->timestamps();
        });

        $user = SYS_User::create([
            'employee_id' => 1,
            'username' => 'admin',
            'password' => bcrypt('admin123'),
            'status' => 1
        ]);

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sys_users');
    }
}
