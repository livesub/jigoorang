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
            $table->integer('de_send_cost_free')->default(0)->comment('기본 배송비 무료 정책');
            $table->integer('od_send_cost')->default(0)->comment('각 상품 배송비');
            $table->integer('od_send_cost2')->default(0)->comment('추가배송비');
            $table->integer('od_receipt_price')->default(0)->comment('결제금액');
            $table->integer('od_receipt_point')->default(0)->comment('결제 포인트');
            $table->integer('tot_item_point')->default(0)->comment('각 상품의 포인트 합');
            $table->string('ad_zip1')->comment('받으시는 분 우편번호');
            $table->string('od_pg')->comment('간편결제 방식');
            $table->string('od_settle_case')->comment('결제방식');
            $table->string('ad_name')->comment('받으시는 분 이름');
            $table->string('ad_tel')->nullable()->comment('받으시는 분 전화번호');
            $table->string('ad_hp')->comment('받으시는 분 휴대폰번호');
            $table->string('ad_addr1')->comment('받으시는 분 기본주소');
            $table->string('ad_addr2')->comment('받으시는 분 상세주소');
            $table->string('ad_addr3')->nullable()->comment('받으시는 분 주소 참고 항목');
            $table->string('ad_jibeon')->nullable()->comment('받으시는 분 지번주소');
            $table->text('od_memo')->nullable()->comment('전하실말씀');
            $table->integer('od_cart_count')->default(0)->comment('장바구니 상품 개수');
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
