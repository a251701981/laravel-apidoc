<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatapiDocsrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_docs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');     //接口名称
            $table->string('descript'); //接口描述
            $table->string('path');     //路径
            $table->string('method');   //请求方法
            $table->text('request');    //请求示例
            $table->text('response');   //响应示例
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
        Schema::drop('api_docs');
    }
}
