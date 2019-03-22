<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateApiDocParams extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('api_docs_params', function (Blueprint $table) {
            $table->integer('api_docs_id');  //接口id
            $table->string('name');     //参数名称
            $table->string('type');     //参数类型
            $table->text('example');    //参数示例
            $table->string('descript'); //参数描述
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
        Schema::drop('api_docs_params');
    }
}
