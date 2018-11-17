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
    {
        Schema::create('records', function (Blueprint $table) {
            $table->increments('id'); 
            $table->string('qqnumber'); 
            $table->string('time');
            $table->string('label');
            $table->string('content');
            $table->timestamps(); 
        });
    }
    //App\Models\Record::create(['qqnumber'=> '250151700', 'time'=>'2018-08-21 10:47:22','label'=>'#我要换组#','content'=>'我在抽奖'])
    
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
