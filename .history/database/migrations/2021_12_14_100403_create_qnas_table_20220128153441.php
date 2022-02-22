<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQnasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('qnas', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('qna_cate')->comment('문의 카테고리');
            $table->string('qna_subject')->comment('글제목');
            $table->bigInteger('order_id')->comment('주문서번호');
            $table->string('user_id')->comment('아이디');
            $table->string('user_name')->comment('이름');
            $table->text('qna_content')->comment('내용');
            $table->text('qna_answer')->nullable()->comment('답변');
            $table->timestamps();
            $table->index(['qna_cate','user_id','order_id']);
        });
        DB::statement("ALTER TABLE qnas comment '1:1 문의'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('qnas');
    }
}
