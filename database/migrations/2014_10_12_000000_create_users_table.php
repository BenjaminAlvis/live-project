<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     * 当我们运行迁移时，up 方法会被调用；
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id'); // increments 方法创建了一个 integer 类型的自增长 id。
            $table->string('name'); // 由 string 方法创建了一个 name 字段，用于保存用户名称。
            $table->string('email')->unique(); // 由 string 方法创建了一个 email 字段，且在最后指定该字段的值为唯一值，用于保存用户邮箱。
            $table->string('password', 60); // 由 string 方法创建了一个 password 字段，且在 string 方法中指定保存的值最大长度为 60，用于保存用户密码。
            $table->rememberToken(); // rememberToken 方法为用户创建一个 remember_token 字段，用于保存『记住我』的相关信息。
            $table->timestamps(); // 由 timestamps 方法创建了一个 created_at 和一个 updated_at 字段，分别用于保存用户的创建时间和更新时间。
        });
    }

    /**
     * Reverse the migrations.
     * 当我们回滚迁移时，down 方法会被调用。
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
