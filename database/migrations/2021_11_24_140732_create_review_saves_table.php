<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewSavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_saves', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->integer('exp_id')->default(0)->comment('체험단 id');
            $table->integer('exp_app_id')->default(0)->comment('체험단 신청 id');
            $table->string('sca_id')->default(0)->comment('카테고리');
            $table->integer('cart_id')->default(0)->comment('장바구니 id');
            $table->string('item_code')->default(0)->comment('상품코드');
            $table->string('user_id')->comment('신청 유저 아이디');
            $table->string('user_name')->comment('신청 유저 이름');
            $table->float('score1')->comment('정량평가 점수1');
            $table->float('score2')->comment('정량평가 점수2');
            $table->float('score3')->comment('정량평가 점수3');
            $table->float('score4')->comment('정량평가 점수4');
            $table->float('score5')->comment('정량평가 점수5');
            $table->float('average')->comment('정량평가 평균점수');
            $table->text('review_content')->comment('리뷰 내용');
            $table->text('review_img1')->nullable()->comment('리뷰 첨부 파일이름1(원본@@썸네일1@@썸네일2..)');
            $table->string('review_img_name1')->nullable()->comment('리뷰 원본파일이름1');
            $table->text('review_img2')->nullable()->comment('리뷰 첨부 파일이름2(원본@@썸네일1@@썸네일2..)');
            $table->string('review_img_name2')->nullable()->comment('리뷰 원본파일이름2');
            $table->text('review_img3')->nullable()->comment('리뷰 첨부 파일이름3(원본@@썸네일1@@썸네일2..)');
            $table->string('review_img_name3')->nullable()->comment('리뷰 원본파일이름3');
            $table->text('review_img4')->nullable()->comment('리뷰 첨부 파일이름1(원본@@썸네일1@@썸네일2..)');
            $table->string('review_img_name4')->nullable()->comment('리뷰 원본파일이름1');
            $table->text('review_img5')->nullable()->comment('리뷰 첨부 파일이름5(원본@@썸네일1@@썸네일2..)');
            $table->string('review_img_name5')->nullable()->comment('리뷰 원본파일이름5');
            $table->enum('temporary_yn', ['y', 'n'])->default('y')->comment('임시저장여부(y=>임시저장, n=>저장)');
            $table->enum('review_blind', ['N', 'Y'])->default('N')->comment('블라인드처리유무(N=>아님, Y=>블라인드)');

            $table->timestamps();
            $table->index(['exp_id', 'exp_app_id', 'sca_id', 'item_code', 'user_id']);
        });

        DB::statement("ALTER TABLE review_saves comment '리뷰 저장 관리'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_saves');
    }
}
