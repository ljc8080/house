<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHouseAttrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('house_attr', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pid')->default('0');
            $table->string('name','20')->default('');
            $table->string('icon','255')->default('0')->comment('图标');
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
        Schema::dropIfExists('house_attr');
    }
}
