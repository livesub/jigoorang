<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopcategorysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shopcategorys', function (Blueprint $table) {
            $table->id()->comment('순번');
            $table->string('sca_id')->unique()->comment('카테고리');
            $table->string('sca_name_kr')->comment('카테고리 한글명');
            $table->string('sca_name_en')->comment('카테고리 영어명');
            $table->enum('sca_display', ['N', 'Y'])->length(2)->default('Y')->comment('출력 여부 : N=>미출력,Y=>출력');
            $table->integer('sca_rank')->default(0)->length(3)->comment('출력순서: 높을수록 먼저 나옴');
            $table->string('sca_img_ori_file_name')->nullable()->comment('원본 첨부파일 이름');
            $table->text('sca_img')->nullable()->comment('첨부파일(원본@@썸네일1@@썸네일2..)');
            $table->enum('sca_rank_dispaly', ['N', 'Y'])->length(2)->default('N')->comment('랭킹 출력 여부 : N=>미출력,Y=>출력');
            $table->timestamps();
            $table->index(['sca_id']);
        });

        DB::statement("ALTER TABLE shopcategorys comment 'shop 카테고리'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shopcategorys');
    }
}
