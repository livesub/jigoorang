<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExpListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exp_list', function (Blueprint $table) {
            $table->id();
            $table->string('title')->comment('체험단 제목');
            $table->string('main_image_name')->comment('메인 이미지 이름');
            $table->integer('item_id')->comment('연계할 상품 아이디');
            $table->integer('item_name')->comment('연계할 상품 이름');
            $table->integer('exp_limit_personnel')->comment('체험단 인원');
            $table->date('exp_date_start')->comment('모집 기간 시작일');
            $table->date('exp_date_end')->comment('모집 기간 종료일');
            $table->date('exp_review_start')->comment('평가 가능 기간 시작일');
            $table->date('exp_review_end')->comment('평가 가능 기간 종료일');
            $table->date('exp_release_date')->comment('당첨자 발표일');
            $table->text('exp_content')->comment('체험단 내용');
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
        Schema::dropIfExists('exp_list');
    }
}
