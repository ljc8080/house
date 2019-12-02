<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',30);
            $table->string('route',255)->comment('路由地址');
            $table->unsignedInteger('pid')->comment('上级权限');
            $table->enum('is_menu',['0','1'])->default('0')->comment('是否菜单');
            $table->softDeletes();
        });

        Schema::create('roles&rules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('rule_id');
            $table->unsignedInteger('role_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rules');
        Schema::dropIfExists('roles&rules');
    }
}
