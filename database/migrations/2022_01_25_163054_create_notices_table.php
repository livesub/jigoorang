<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNoticesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notices', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('n_subject')->comment('제목');
            $table->string('n_explain')->comment('설명글');
            $table->text('n_img')->comment('원본@@썸네일1@@썸네일2..');
            $table->string('n_img_name')->comment('이미지파일이름');
            $table->integer('n_view_cnt')->default(0)->comment('조회수');
            $table->text('n_content')->comment('내용');

            $table->timestamps();
        });

        DB::statement("ALTER TABLE notices comment '지구록 관리(소식)'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notices');
    }
}
