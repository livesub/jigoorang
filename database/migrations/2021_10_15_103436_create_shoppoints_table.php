<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShoppointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoppoints', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('user_id')->comment('아이디');
            $table->string('po_content')->comment('적립 내용');
            $table->integer('po_point')->default(0)->comment('적립금액');
            $table->integer('po_use_point')->default(0)->comment('사용금액');
            $table->integer('po_user_point')->default(0)->comment('적립전 회원 포인트');
            $table->tinyInteger('po_type')->length(2)->default(1)->comment('적립금 지금 유형 : 1=>회원가입,3=>구매평,5=>체험단평,7=>상품구입');
            $table->integer('po_write_id')->default(0)->comment('적립금 지급 유형 글번호');
            $table->string('order_id')->comment('주문번호');
            $table->timestamps();
            $table->index(['user_id']);
        });

        DB::statement("ALTER TABLE shoppoints comment '포인트 관리'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shoppoints');
    }
}
