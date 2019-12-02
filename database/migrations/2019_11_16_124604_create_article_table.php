<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('cid')->default(0)->comment('分类ID');
            $table->string('title',255)->comment('文章标题');
            $table->string('des',255)->default('')->comment('文章摘要');
            $table->string('pic',255)->default('')->comment('文章封面');
            $table->text('body')->comment('文章内容');
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
        Schema::dropIfExists('article');
    }
}
