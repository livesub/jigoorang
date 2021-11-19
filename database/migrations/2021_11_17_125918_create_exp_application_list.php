<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpApplicationList extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exp_application_list', function (Blueprint $table) {

            $table->id();
            $table->integer('user_id')->comment('신청 유저 아이디');
            $table->string('user_name')->comment('신청자 이름');
            $table->integer('exp_id')->comment('체험단 아이디');
            $table->integer('item_id')->comment('상품 아이디');
            $table->integer('sca_id')->comment('카테고리 아이디');
            $table->string('ad_name')->comment('수령인');
            $table->string('ad_hp')->comment('핸드폰 번호');
            $table->string('ad_zip1')->comment('신청인 우편번호');
            $table->string('ad_addr1')->comment('신청인 기본주소');
            $table->string('ad_addr2')->comment('신청인 상세주소');
            $table->string('ad_addr3')->comment('신청인 주소참고항목');
            $table->string('ad_jibeon')->comment('신청인 지번주소');
            $table->string('shipping_memo')->nullable()->comment('배송메모');
            $table->text('reason_memo')->comment('참여하는 이유항목');
            $table->enum('access_yn', ['y', 'n'])->default('n')->comment('승인 여부');
            $table->enum('write_yn', ['y', 'n'])->default('n')->comment('리뷰 작성 여부');
            $table->enum('promotion_yn', ['y', 'n'])->default('y')->comment('약관동의 여부');
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
        Schema::dropIfExists('exp_application_list');
    }
}
