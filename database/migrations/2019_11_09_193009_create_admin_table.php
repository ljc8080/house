<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username',50)->default(uniqid())->comment('昵称');
            $table->string('truename',10)->default('')->comment('真实姓名');
            $table->string('password',255);
            $table->string('email',100)->unique()->default('');
            $table->char('phone',11)->unique()->default('');
            $table->enum('sex',['先生','女士'])->default('先生');
            $table->char('last_ip',15)->default('')->comment('上次登录ip');
            $table->integer('create_time')->unsigned()->default(0);
            $table->unsignedInteger('role_id')->default(1)->comment('角色id');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin');
    }
}
