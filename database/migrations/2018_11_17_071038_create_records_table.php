<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   /*
        表：聊天记录
        作者：赵畅
        */
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id');  // id，从1递增的正整数，主码
            $table->string('qqnumber'); // 发言人的QQ号
            $table->string('time'); // 发言时间
            $table->string('label'); // 发言内容其中的抽奖标签部分
            $table->string('content', 1024); // 全部的发言内容，长度限定为1024
            $table->timestamps(); 
        });
    }
    
    // 测试语句：App\Models\Record::create(['qqnumber'=> '250151700', 'time'=>'2018-08-21 10:47:22','label'=>'#我要换组#','content'=>'#我要换组#我在抽奖'])
    
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('records');
    }
}
