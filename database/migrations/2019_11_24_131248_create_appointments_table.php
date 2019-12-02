<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('fangowner_id')->comment('房东ID');
            $table->unsignedInteger('renting_id')->default(1)->comment('租客ID');
            $table->dateTime('dtime')->nullable()->comment('时间');
            $table->string('cnt',500)->default('')->comment('内容');
            $table->enum('status',['0','1'])->default('0')->comment('状态 0未看，1已看 2过期');
            $table->unsignedInteger('create_time')->default(0);
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
        Schema::dropIfExists('appointments');
    }
}
