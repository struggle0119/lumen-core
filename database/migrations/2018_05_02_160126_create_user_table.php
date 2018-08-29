<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function(Blueprint $table) {
            $table->engine='InnoDB';
            $table->unsignedBigInteger('id', true)->comment('用户自增id');
            $table->string('name', 64)->comment('用户名');
            $table->string('password', 64)->comment('密码');
            $table->string('nick_name', 32)->nullable()->comment('昵称');
            $table->string('avatar', 256)->nullable()->comment('头像');
            $table->unsignedTinyInteger('gender')->nullable()->comment('性别');
            $table->string('mobile', 16)->nullable()->comment('手机号');
            $table->timestamp('login_time')->comment('登录时间')->nullable();
            $table->timestamp('create_time')->comment('创建时间');
            $table->timestamp('update_time')->comment('修改时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
    }
}
