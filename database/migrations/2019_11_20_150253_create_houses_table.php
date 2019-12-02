<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('house_name',100)->default('')->comment('房源名称');
            $table->string('house_xiaoqu',100)->default('')->comment('房源小区名称');
            $table->unsignedInteger('house_province')->default(0)->comment('省');
            $table->unsignedInteger('house_city')->default(0)->comment('市');
            $table->unsignedInteger('house_region')->default(0)->comment('区');
            $table->string('house_addr',200)->default('')->comment('房源地址');
            $table->unsignedInteger('house_direction')->default(0)->comment('房源朝向');
            $table->unsignedInteger('house_build_area')->default(0)->comment('房源面积');
            $table->unsignedInteger('house_using_area')->default(0)->comment('使用面积');
            $table->unsignedInteger('house_year')->default(2000)->comment('建筑年代');
            $table->unsignedInteger('house_rent')->default(0)->comment('租金');
            $table->unsignedTinyInteger('house_floor')->default(1)->comment('楼层');
            $table->unsignedTinyInteger('house_shi')->default(1)->comment('几室');
            $table->unsignedTinyInteger('house_ting')->default(1)->comment('几厅');
            $table->unsignedTinyInteger('house_wei')->default(1)->comment('几卫');
            $table->string('house_pic',600)->default('')->comment('房屋图片');
            $table->unsignedInteger('house_rent_class')->default(0)->comment('租赁方式');
            $table->string('house_config',100)->default('')->comment('配套设施');
            $table->unsignedInteger('house_area')->default(0)->comment('区域');
            $table->unsignedInteger('house_rent_range')->default(0)->comment('租金范围');
            $table->unsignedInteger('house_rent_type')->default(0)->comment('租期方式');
            $table->unsignedInteger('house_status')->default(0)->comment('房源状态');
            $table->unsignedInteger('house_owner')->default(0)->comment('业主');
            $table->string('house_desn',500)->default('')->comment('房源描述-es');
            $table->text('house_body')->comment('房源信息');
            $table->unsignedInteger('house_group')->default(0)->comment('租房小组');
            $table->enum('is_recommend',['0','1'])->default('0')->comment('是否推荐:0否，1是');
            $table->decimal('latitude',10,4)->default(0)->comment('纬度');
            $table->decimal('longitude',10,4)->default(0)->comment('经度');
            $table->unsignedInteger('create_time')->default(0);
            $table->unsignedInteger('update_time')->default(0);
            // 软删除
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
        Schema::dropIfExists('houses');
    }
}
