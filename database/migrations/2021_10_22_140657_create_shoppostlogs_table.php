<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppostlogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoppostlogs', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->bigInteger('oid')->comment('장바구니 unique 키');
            $table->string('user_id')->comment('아이디');
            $table->text('post_data')->comment('기록');
            $table->string('ol_code')->comment('code');
            $table->string('ol_msg')->comment('메세지');
            $table->string('ol_ip')->comment('ip');
            $table->timestamps();
            $table->index(['oid']);
        });

        DB::statement("ALTER TABLE shoppostlogs comment '주문요청기록 로그'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shoppostlogs');
    }
}
