<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopordertempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopordertemps', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->bigInteger('order_id')->comment('주문서번호');
            $table->bigInteger('od_id')->comment('장바구니 unique 키');
            $table->string('user_id')->comment('아이디');
            $table->integer('od_cart_price')->default(0)->comment('주문상품 총금액');
            $table->integer('de_send_cost')->default(0)->comment('기본 배송비');
            $table->integer('od_send_cost')->default(0)->comment('각 상품 배송비');
            $table->integer('od_send_cost2')->default(0)->comment('추가배송비');
            $table->integer('od_receipt_price')->default(0)->comment('결제금액');
            $table->integer('od_receipt_point')->default(0)->comment('결제 포인트');
            $table->integer('tot_item_point')->default(0)->comment('각 상품의 포인트 합');
            $table->char('ad_zip1')->length(5)->comment('받으시는 분 우편번호');
            $table->string('od_ip')->comment('주문자IP');
            $table->timestamps();
            $table->index(['order_id','od_id','user_id']);
        });

        DB::statement("ALTER TABLE shopordertemps comment '결제전주문검증'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopordertemps');
    }
}
