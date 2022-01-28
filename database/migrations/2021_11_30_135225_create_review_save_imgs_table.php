<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewSaveImgsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('review_save_imgs', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->integer('rs_id')->default(0)->comment('리뷰 순번');
            $table->text('review_img')->nullable()->comment('리뷰 첨부 파일이름1(원본@@썸네일1@@썸네일2..)');
            $table->string('review_img_name')->nullable()->comment('리뷰 원본파일이름1');

            $table->timestamps();
            $table->index(['rs_id']);
        });
        DB::statement("ALTER TABLE review_save_imgs comment '리뷰 이미지 첨부 파일 모음'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('review_save_imgs');
    }
}
