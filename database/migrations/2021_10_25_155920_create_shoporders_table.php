<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shoporders', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->bigInteger('order_id')->comment('주문서번호');
            $table->bigInteger('od_id')->comment('장바구니 unique 키');
            $table->string('user_id')->comment('아이디');
            $table->string('od_deposit_name')->comment('입금자');
            $table->string('ad_name')->comment('받으시는 분 이름');
            $table->string('ad_tel')->nullable()->comment('받으시는 분 전화번호');
            $table->string('ad_hp')->comment('받으시는 분 휴대폰번호');
            $table->string('ad_zip1')->comment('받으시는 분 우편번호');
            $table->string('ad_addr1')->comment('받으시는 분 기본주소');
            $table->string('ad_addr2')->comment('받으시는 분 상세주소');
            $table->string('ad_addr3')->nullable()->comment('받으시는 분 주소 참고 항목');
            $table->string('ad_jibeon')->nullable()->comment('받으시는 분 지번주소');
            $table->text('od_memo')->nullable()->comment('전하실말씀');
            $table->integer('od_cart_count')->default(0)->comment('장바구니 상품 개수');
            $table->integer('od_cart_price')->default(0)->comment('주문상품 총금액');
            $table->integer('de_send_cost')->default(0)->comment('기본 배송비(3만원이하 취소시 기본 배송비를 알기 위함-계산 안함)');
            $table->integer('de_send_cost_free')->default(0)->comment('기본 배송비 무료 정책');
            $table->integer('od_send_cost')->default(0)->comment('각 상품 배송비');
            $table->integer('od_send_cost2')->default(0)->comment('추가배송비');
            $table->integer('od_receipt_price')->default(0)->comment('결제금액');
            $table->integer('od_cancel_price')->default(0)->comment('취소금액');
            $table->integer('od_receipt_point')->default(0)->comment('결제시 사용 포인트');
            $table->integer('real_card_price')->default(0)->comment('실제 카드 결제금액');
            $table->integer('od_return_point')->default(0)->comment('취소시 반환 포인트');
            $table->integer('od_refund_price')->default(0)->comment('반품, 품절 금액');
            $table->string('od_receipt_time')->comment('결제일시');
            $table->text('od_shop_memo')->nullable()->comment('상점메모');
            $table->string('od_status')->comment('주문상태');
            $table->string('od_settle_case')->comment('결제방식');
            $table->string('od_pg')->comment('간편결제 방식');
            $table->string('od_tno')->comment('거래번호');
            $table->string('imp_uid')->comment('아임포트 코드');
            $table->string('imp_apply_num')->nullable()->comment('아임포트 승인번호');
            $table->string('imp_card_name')->nullable()->comment('카드사에서 전달 받는 값(카드사명칭)');
            $table->string('imp_card_quota')->nullable()->comment('카드사에서 전달 받는 값(할부개월수)');
            $table->string('imp_card_number')->nullable()->comment('카드사에서 전달 받는 값(카드번호)');
            $table->string('od_delivery_company')->nullable()->comment('배송회사');
            $table->string('od_delivery_tel')->nullable()->comment('배송회사전화번호');
            $table->string('od_delivery_url')->nullable()->comment('배송조회URL');
            $table->string('od_invoice')->nullable()->comment('운송장번호');
            $table->string('od_invoice_date')->nullable()->comment('운송장 입력일');
            $table->integer('od_misu')->default(0)->comment('미수금');
            $table->integer('de_cost_minus')->default(0)->comment('무료배송비 이하 취소시 한번 빼줬다는 표시');
            $table->text('od_mod_history')->nullable()->comment('상태변경 히스토리');
            $table->string('od_ip')->comment('주문자IP');
            $table->integer('tot_item_point')->default(0)->comment('포인트 사용금액을 뺀 적립 포인트');
            $table->integer('set_tot_item_point')->default(0)->comment('주문 당시 포인트 적립율');
            $table->string('pay_cancel_date')->nullable()->comment('취소 날짜');
            $table->enum('send_complete_chk', ['N', 'Y'])->default('N')->comment('배송완료 여부');
            $table->enum('exchange_item_chk', ['N', 'Y'])->default('N')->comment('교환건여부');
            $table->timestamps();
            $table->index(['order_id','od_id','user_id']);
        });

        DB::statement("ALTER TABLE shoporders comment '주문서'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shoporders');
    }
}
